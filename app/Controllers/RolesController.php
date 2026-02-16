<?php

namespace Controllers;

use Core\Database;
use Repositories\ProductsRepository;
use Repositories\RolesRepository;
use Repositories\UserRepository;

class RolesController
{
    private RolesRepository $rolesRepository;
    private ProductsRepository $productsRepository;

    public function __construct()
    {
        $db = Database::getInstance()->getConnection();
        $this->rolesRepository = new RolesRepository($db);
        $this->productsRepository = new ProductsRepository($db);
    }

    /**
     * Return all records in bd
     *
     * @return mixed
     */
    public function list(): array
    {
        $this->productsRepository
            ->getAll()
            ->sortBy('id')
            ->limit(10);

        return $this->rolesRepository->getAll();
    }
}
