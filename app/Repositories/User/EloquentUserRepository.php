<?php

namespace App\Repositories\User;

use App\Persistences\Eloquent\BaseEloquentAbstractRepository;
use Jenssegers\Mongodb\Eloquent\Model;

class EloquentUserRepository
    extends BaseEloquentAbstractRepository
    implements UserRepositoryInterface
{

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

}
