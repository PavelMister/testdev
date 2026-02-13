<?php

namespace Core;

use PDO;

class DefaultRepository
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
}