<?php

namespace App\Repositories\User;

use App\Entities\User\UserRepository;
use App\Persistences\Eloquent\BaseEloquentAbstractRepository;
use Jenssegers\Mongodb\Eloquent\Model;

class UserRepositoryEloquent
    extends BaseEloquentAbstractRepository
    implements UserRepository
{

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

}
