<?php

namespace App\Repositories\Tenant;

use App\Entities\Tenant\TenantRepository;
use App\Persistences\Eloquent\BaseEloquentAbstractRepository;
use Jenssegers\Mongodb\Eloquent\Model;

class TenantRepositoryEloquent
    extends BaseEloquentAbstractRepository
    implements TenantRepository
{

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

}
