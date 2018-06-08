<?php

namespace App\Repositories\Privilege;

use App\Persistences\Eloquent\BaseEloquentAbstractRepository;
use Jenssegers\Mongodb\Eloquent\Model;

class EloquentPrivilegeRepository
    extends BaseEloquentAbstractRepository
    implements PrivilegeRepositoryInterface
{

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

}