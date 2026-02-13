<?php

namespace Repositories;

use Core\DefaultRepository;

class ProductsRepository extends DefaultRepository
{
    private array $modelColumns = [
        'id', 'slug', 'name', 'price'
    ];

    public function getAll($orderBy = 'id'): array
    {
        $allowedColumns = $this->modelColumns;

        if (!in_array($orderBy, $allowedColumns)) {
            return [];
        }

        $query = $this->db->prepare('SELECT * FROM products ORDER BY :orderBy ASC');

        var_dump($query->execute(['orderBy' => $orderBy]));

        return $query->fetchAll() ?? [];
    }
}