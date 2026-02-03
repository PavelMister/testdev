<?php

namespace Controllers;

use Core\Database;
use Repositories\UserRepository;

class UsersController
{
    private UserRepository $userRepository;

    public function __construct($action) {
        $db = Database::getInstance()->getConnection();
        $this->userRepository = new UserRepository($db);

        if (method_exists($this, $action)) {
            header('Content-Type: application/json');
            echo $this->$action;
            exit;
        }
    }

    /**
     * @return mixed
     */
    private function actionUsersList(): array
    {
        return $this->userRepository->getAll();
    }
}