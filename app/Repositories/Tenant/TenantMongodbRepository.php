<?php

namespace App\Repositories\Tenant;

use App\Persistences\Mongodb\BaseMongodbAbstractRepository;
use Jenssegers\Mongodb\Eloquent\Model;

class TenantMongodbRepository
    extends BaseMongodbAbstractRepository
    implements TenantRepositoryInterface
{

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

}
