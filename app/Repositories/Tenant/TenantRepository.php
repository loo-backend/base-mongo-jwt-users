<?php

namespace App\Repositories\Tenant;


use Illuminate\Database\Eloquent\Model;

class RoleRepository implements RoleRepositoryInterface
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
