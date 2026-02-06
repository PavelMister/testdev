<?php

namespace Repositories;

use Core\Config;
use PDO;

class RolesRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Get all roles
     * @return array
     */
    public function getAll(): array
    {
        return $this->db->query("SELECT * FROM roles ORDER BY id ASC")->fetchAll() ?? [];
    }
}
