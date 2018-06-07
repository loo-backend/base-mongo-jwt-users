<?php

namespace App\Repositories\Privilege;

use App\Entities\Privilege\PrivilegeRepository;
use App\Persistences\Eloquent\BaseEloquentAbstractRepository;
use Jenssegers\Mongodb\Eloquent\Model;

class PrivilegeRepositoryEloquent
    extends BaseEloquentAbstractRepository
    implements PrivilegeRepository
{

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

}
