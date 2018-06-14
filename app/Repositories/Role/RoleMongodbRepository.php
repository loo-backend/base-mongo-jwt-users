<?php

namespace App\Repositories\Role;

use App\Persistences\Eloquent\BaseEloquentAbstractRepository;
use Jenssegers\Mongodb\Eloquent\Model;

class RoleMongodbRepository
    extends BaseEloquentAbstractRepository
    implements RoleRepositoryInterface
{

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

}
