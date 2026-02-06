<?php

namespace Controllers;

use Core\Database;
use Core\ApiResponse;
use Repositories\GoodsRepository;

class GoodsController
{
    private GoodsRepository $goodsRepository;

    public function __construct() {
        $db = Database::getInstance()->getConnection();
        $this->goodsRepository = new GoodsRepository($db);
    }

    /**
     * Return all records in bd
     *
     */
    public function index(): void
    {
        $goods = $this->goodsRepository->getGoodsReport();

        var_export($goods);
//        ApiResponse::success();
    }
}