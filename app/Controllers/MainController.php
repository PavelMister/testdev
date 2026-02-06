<?php

namespace Controllers;

use Core\Config;
use Core\View;

class MainController extends View
{
    private GoodsController $goods;
    public function __construct()
    {
        $this->goods = new GoodsController();
    }

    public function index(): string
    {
        return $this->renderView('index_page.php', [
            'title' => Config::get('app')['name']
        ]);
    }

    public function goods(): string
    {
        return $this->renderText($this->goods->list());
    }
}
