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

    /**
     * @param string $query
     * @param string $column
     * @return array
     */
    public function search(string $query, string $column = 'first_name'): array
    {
        return $this->userRepository->search($query, $column);
    }
}