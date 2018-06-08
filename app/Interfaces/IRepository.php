<?php

namespace App\Interfaces;

interface IRepository
{

    public function all(array $with = []);
    public function findById($id);
    public function search($data);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function count($active=true);
    public function whereFirst(array $data);
    public function whereExists(array $data);

}
