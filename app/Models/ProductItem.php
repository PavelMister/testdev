<?php

namespace Models;

class ProductItem extends Model
{
    public int $id;

    public string $name;
    public string $slug;
    public float $price;
    public bool $deleted;
    public int $category_id;
    public ?string $description;
    public ?array $category;

    public array $modelColumns = [
        'id', 'name', 'slug', 'price', 'deleted', 'category_id', 'description'
    ];
}
