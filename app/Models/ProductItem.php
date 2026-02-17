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

    public int $user_id;
    public string $updated_at;
    public string $created_at;

    public array $modelColumns = [
        'id', 'name', 'slug', 'price', 'deleted', 'category_id', 'description', 'user_id'
    ];
}
