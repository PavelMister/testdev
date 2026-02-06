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
     * Return all records in bd
     *
     * @return mixed
     */
    public function list(): array
    {
        return $this->userRepository->getAll();
    }

    /**
     * Search user like by query and column
     *
     * @param string $query
     * @param string $column
     * @return array
     */
    public function search(string $query, string $column = 'first_name'): array
    {
        return $this->userRepository->search($query, $column);
    }

    /**
     * Delete user
     *
     * @param array $data
     * @return bool
     */
    public function delete(array $data): bool
    {
        return $this->userRepository->delete($data['userId']);
    }


    public function update(array $data): bool
    {
        return $this->userRepository->update($data);
    }

    public function create(array $data): bool
    {
        return $this->userRepository->create($data);
    }
}