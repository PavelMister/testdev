<?php

namespace Controllers;

use Core\View;
use Core\Config;

class MainController extends View
{
    private ProductsController $products;
    public function __construct()
    {
        $this->products = new ProductsController();
    }

    public function index(): string
    {
        return $this->renderView('index_page.php', [
            'title' => Config::get('app')['name']
        ]);
    }

    public function test($parameters): string
    {
        var_dump($this->products->list(...$parameters));
        return '';
    }
}
