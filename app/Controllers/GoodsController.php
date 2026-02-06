<?php

namespace Controllers;

use Core\Database;
use Core\ApiResponse;
use Repositories\GoodsRepository;

class GoodsController
{
    private GoodsRepository $goodsRepository;

    public function __construct()
    {
        $db = Database::getInstance()->getConnection();
        $this->goodsRepository = new GoodsRepository($db);
    }

    /**
     * Return all records in bd
     */
    public function list(): string
    {
        $goods = $this->goodsRepository->getGoodsReport();

        ApiResponse::success($goods);
    }
}
