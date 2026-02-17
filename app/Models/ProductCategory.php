<?php

namespace Models;

class ProductCategory extends Model
{
    protected array $columns = [
        'id', 'name', 'slug'
    ];

    public int $id;

    public string $name;
    public string $slug;
}
