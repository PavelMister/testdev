<?php

namespace Core;

use PDO;
use const Dom\VALIDATION_ERR;

abstract class DefaultRepository
{
    protected PDO $db;

    protected string $modelTable = '';

    protected const string DEFAULT_ORDER_TYPE = 'ASC';

    protected string $modelClass = '';

    protected array $relations = [];
    protected array $modelColumns = [];

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    private function hydrate(array $data): object
    {
        $model = new $this->modelClass;

        foreach ($data as $key => $value) {
            $model->{$key} = $value;
        }

        return $model;
    }

    public function getAllWith(
        array $with = [],
        string $orderBy   = 'id',
        string $orderType = self::DEFAULT_ORDER_TYPE,
        int $startRow  = 1,
        int $endRow    = 50)
    : array
    {
        if (empty($this->modelTable)) {
            throw new \Exception('is empty $modelTable in repository');
        }

        if (!in_array($orderBy, $this->modelColumns)) {
            $orderBy = 'id';
        }

        $orderType = strtoupper($orderType) === 'DESC' ? 'DESC' : self::DEFAULT_ORDER_TYPE;

        $selects = ["p.*"];
        $joins = "";

        foreach ($with as $relationName) {
            if (isset($this->relations[$relationName])) {
                $rel = $this->relations[$relationName];
                $table = $rel['table'];

                foreach ($rel['columns'] as $column) {
                    $alias = "rel_{$relationName}_{$column}";
                    $selects[] = "{$table}.{$column} AS {$alias}";
                }

                $joins .= " LEFT JOIN {$table} ON p.{$rel['foreign_key']} = {$table}.{$rel['local_key']}";
            }
        }

        $sql = "SELECT * FROM (
                    SELECT " . implode(', ', $selects) . ", 
                    ROW_NUMBER() OVER (ORDER BY p.id ASC) as row_id
                    FROM {$this->modelTable} AS p 
                    {$joins}
                ) as sub_query
                WHERE sub_query.row_id BETWEEN :startRow AND :endRow
                ORDER BY sub_query.{$orderBy} {$orderType}";

        $query = $this->db->prepare($sql);

        $query->bindValue(':startRow', (int)$startRow, PDO::PARAM_INT);
        $query->bindValue(':endRow', (int)$endRow, PDO::PARAM_INT);

        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC) ?? [];
        $mapped = $this->mapRelations($results, $with); //

        return array_map([$this, 'hydrate'], $mapped);
    }

    private function mapRelations(array $results, array $with): array
    {
        return array_map(function($row) use ($with) {
            foreach ($with as $relationName) {
                $relation = $this->relations[$relationName];
                $row[$relationName] = [];

                foreach ($relation['columns'] as $column) {
                    $alias = "rel_{$relationName}_{$column}";
                    $row[$relationName][$column] = $row[$alias] ?? null;
                    unset($row[$alias]);
                }
            }

            return $row;
        }, $results);
    }
}
