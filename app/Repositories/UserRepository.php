<?php

namespace Repositories;

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
        return $this->db->query("SELECT * FROM users ORDER BY id DESC")->fetchAll() ?? [];
    }

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
    public function create($data): bool
    {
        $stmt = $this->db->prepare("INSET INFO USERS (first_name, last_name, position) VALUES (?, ?, ?)");

        return $stmt->execute([$data['first_name'], $data['last_name'], $data['position']]);
    }

}