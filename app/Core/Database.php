<?php

namespace Core;

class Database
{
    protected \PDO $instance;

    public function __construct()
    {
        $this->instance = new \PDO("mysql:host=' . $_ENV('db_host') . ';dbname=" . $_ENV('db_name'), $_ENV('db_user'),
            $_ENV('db_pass'));
    }

    public function getInstance()
    {
        return $this->instance;
    }
}