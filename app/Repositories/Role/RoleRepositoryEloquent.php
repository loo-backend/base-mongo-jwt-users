<?php

namespace App\Repositories\Role;

use App\Entities\Role\RoleRepository;
use App\Persistences\Eloquent\BaseEloquentAbstractRepository;
use Jenssegers\Mongodb\Eloquent\Model;

class RoleRepositoryEloquent
    extends BaseEloquentAbstractRepository
    implements RoleRepository
{

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

}
