<?php

namespace Repositories;

use Core\Config;
use PDO;

class UserRepository
{
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Get all users
     * @return array
     */
    public function getAll(): array
    {
        $limit = Config::get('db')['limit'];

        $sql = "SELECT 
                    users.*,
                    roles.name as role_name
                FROM users
                LEFT JOIN roles ON users.role_id = roles.id
                ORDER BY id ASC
                LIMIT {$limit}";

        return $this->db->query($sql)->fetchAll() ?? [];
    }

    /**
     * Search user by column
     *
     * @param string $query
     * @param string $column
     * @return array
     */
    public function search(string $query, string $column): array
    {
        $allowedColumns = ['first_name', 'last_name', 'role_id'];

        if (trim($query) === '') {
            return [];
        }

        if (!in_array($column, $allowedColumns)) {
            $column = $allowedColumns[0];
        }

        $sql = "SELECT * FROM users WHERE {$column} LIKE :query";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'query' => '%' . $query . '%'
        ]);

        return $stmt->fetchAll() ?: [];
    }

    /**
     * Create new user
     * @param $data
     * @return bool
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO users (first_name, last_name, role_id) 
                VALUES (:first_name, :last_name, :role_id)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'first_name' => $data['firstName'] ?? $data['first_name'],
            'last_name'  => $data['lastName'] ?? $data['last_name'],
            'role_id'    => $data['roleId'] ?? 2,
        ]);
    }

    /**
     * Delete query
     *
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM users WHERE id = :id');

        return $stmt->execute(['id' => $id]);
    }

    /**
     * Update query
     *
     * @param array $params
     * @return bool
     */
    public function update(array $params): bool
    {
        if (empty($params['userId'])) {
            return false;
        }

        $fields = [];
        $bindings = ['id' => $params['userId']];

        $allowedFields = [
            'first_name' => 'firstName',
            'last_name'  => 'lastName',
            'role_id'    => 'roleId'
        ];

        foreach ($allowedFields as $dbColumn => $paramKey) {
            if (isset($params[$paramKey]) && $params[$paramKey] !== '') {
                $fields[] = "{$dbColumn} = :{$paramKey}";
                $bindings[$paramKey] = $params[$paramKey];
            }
        }

        if (empty($fields)) {
            return false;
        }

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($bindings);
    }
}