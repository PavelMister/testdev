<?php

namespace Repositories;

use Core\DefaultRepository;

class ProductsRepository extends DefaultRepository
{
    public string $modelTable = 'products';
    public array $modelColumns = [
        'id', 'slug', 'name', 'price'
    ];

    protected array $relations = [
        'category' => [
            'table' => 'product_categories',
            'foreign_key' => 'category_id',
            'local_key' => 'id',
            'columns' => ['id', 'name', 'slug']
        ]
    ];

    public function getAll($orderBy, $orderType, $startRow = 1, $endRow = 50): array
    {
        return $this->getAllWith(
            with: ['category'],
            orderBy: $orderBy,
            orderType: $orderType,
            startRow: $startRow,
            endRow: $endRow,
        );
    }

    public function search($orderBy = 'id'): array
    {
        return $this->getAllWith(['category'], $orderBy);
    }
}
