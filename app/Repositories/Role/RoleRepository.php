<?php

namespace App\Repositories\User;


use Illuminate\Database\Eloquent\Model;

class UserRepository implements UserRepositoryInteface
{

    /**
     * @var Model
     */
    private $model;

    /**
     * UserRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

}
