<?php

namespace Controllers;

use Core\ApiResponse;
use Core\Database;
use Helpers\ValidationHelper;
use Repositories\ProductsRepository;

class ProductsController
{
    private ProductsRepository $productsRepository;

    public function __construct()
    {
        $db = Database::getInstance()->getConnection();
        $this->productsRepository = new ProductsRepository($db);
    }

    protected array $rules = [
        'firstName' => ['required', 'type' => 'string', 'min' => 2, 'max' => 50],
        'lastName'  => ['required', 'type' => 'string', 'min' => 2, 'max' => 50],
        'roleId'    => ['required', 'type' => 'numeric', 'min' => 1, 'max' => 3],
    ];

    /**
     * Return all records in bd
     *
     * @return mixed
     */
    public function list(): array
    {
        return $this->productsRepository->getAll();
    }
//
//    /**
//     * Search user like by query and column
//     *
//     * @param string $query
//     * @param string $column
//     * @return array
//     */
//    public function search(string $query, string $column = 'first_name'): array
//    {
//        return $this->userRepository->search($query, $column);
//    }
//
//    /**
//     * Delete user
//     *
//     * @param array $data
//     * @return bool
//     */
//    public function delete(array $data): bool
//    {
//        return $this->userRepository->delete($data['userId']);
//    }
//
//
//    public function update(array $data): bool
//    {
//        $errors = ValidationHelper::validate($this->rules, $data);
//
//        if (count($errors) > 0) {
//            ApiResponse::error('Error', 400, $errors);
//        }
//
//        ApiResponse::success($this->userRepository->update($data));
//    }
//
//    public function create(array $data): bool
//    {
//        $errors = ValidationHelper::validate($this->rules, $data);
//
//        if (count($errors) > 0) {
//            ApiResponse::error('Error', 400, $errors);
//        }
//
//        ApiResponse::success($this->userRepository->create($data));
//    }
}
