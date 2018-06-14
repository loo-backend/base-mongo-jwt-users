<?php

namespace App\Repositories\Role;

use App\Persistences\Mongodb\BaseMongodbAbstractRepository;
use Jenssegers\Mongodb\Eloquent\Model;

class RoleMongodbRepository
    extends BaseMongodbAbstractRepository
    implements RoleRepositoryInterface
{

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

}
