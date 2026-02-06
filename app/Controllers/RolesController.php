<?php

namespace Controllers;

use Core\Database;
use Repositories\RolesRepository;
use Repositories\UserRepository;

class RolesController
{
    private RolesRepository $rolesRepository;

    public function __construct() {
        $db = Database::getInstance()->getConnection();
        $this->rolesRepository = new RolesRepository($db);
    }

    /**
     * Return all records in bd
     *
     * @return mixed
     */
    public function list(): array
    {
        return $this->rolesRepository->getAll();
    }
}