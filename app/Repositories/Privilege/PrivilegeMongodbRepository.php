<?php

namespace App\Repositories\Privilege;

use App\Persistences\Mongodb\BaseMongodbAbstractRepository;
use Jenssegers\Mongodb\Eloquent\Model;

class PrivilegeMongodbRepository
    extends BaseMongodbAbstractRepository
    implements PrivilegeRepositoryInterface
{

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

}
