<?php


namespace App\Persistences\Eloquent;


interface BaseEloquentAbstractInterface
{

    public function all(array $with = []);
    public function findById($id);
    public function search($data);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);

}
