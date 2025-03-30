<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function all(array $columns = ['*']);
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($id);
    public function find($id);
    public function findByField($field, $value);
    public function findWhere(array $criteria);
    public function paginate($perPage = 15);
}
