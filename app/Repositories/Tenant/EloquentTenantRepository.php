<?php

namespace App\Repositories\Tenant;

use App\Persistences\Eloquent\BaseEloquentAbstractRepository;
use Jenssegers\Mongodb\Eloquent\Model;

class EloquentTenantRepository
    extends BaseEloquentAbstractRepository
    implements TenantRepositoryInterface
{

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

}
