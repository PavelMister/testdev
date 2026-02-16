<?php

namespace Repositories;

use Core\DefaultRepository;

class RolesRepository extends DefaultRepository
{

    /**
     * Get all roles
     * @return array
     */
    public function getAll(): array
    {
        return $this->db->query("SELECT * FROM roles ORDER BY id ASC")->fetchAll() ?? [];
    }
}
