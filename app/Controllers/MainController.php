<?php

namespace Controllers;


use Core\Config;
use Core\View;

class MainController extends View
{
    public function index(): string
    {
        return $this->renderView('index_page.php', [
            'title' => Config::get('app')['name']
        ]);
    }

    public function goods()
    {
        return (new GoodsController())->index();
    }
}