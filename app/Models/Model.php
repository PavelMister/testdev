<?php

namespace Models;

abstract class Model implements ModelInterface
{
    private array $modelColumns = [
        'id'
    ];

    public ?int $row_id;

    /**
     * Flag of loaded model by db.
     * @var bool
     */
    protected bool $loadedModel = false;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->fill($data);
        }
    }

    public function fill(array $parameters): void
    {
        foreach ($parameters as $column => $value) {
            if (property_exists($this, $column)) {
                $this->{$column} = $value;
            }
        }

        if (count($this->modelColumns) <= count($parameters)) {
            $this->loadedModel = true;
        }
    }

    public function getColumns(): array
    {
        return $this->modelColumns;
    }
}