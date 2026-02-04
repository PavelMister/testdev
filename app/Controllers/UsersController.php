<?php

namespace Controllers;

use Core\Database;
use Repositories\UserRepository;

class UsersController
{
    private UserRepository $userRepository;

    public function __construct() {
        $db = Database::getInstance()->getConnection();
        $this->userRepository = new UserRepository($db);
    }

    /**
     * @return mixed
     */
    public function list(): array
    {
        return $this->userRepository->getAll();
    }

    public function index(): string
    {
        return 'Html empty template';
    }
}