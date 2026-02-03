<?php

namespace Controllers;

use Core\Database;
use Repositories\UserRepository;

class UsersController
{
    public function __construct(
        private UserRepository $userRepository = new UserRepository()
    ) {
        $db = Database::getInstance()->getConnection();
    }

    /**
     * @return mixed
     */
    public function actionUsersList()
    {
        return (new UserRepository())->getAll();
    }
}