<?php

namespace App\Repositories\Log;

use App\Persistences\Eloquent\BaseEloquentAbstractRepository;
use Jenssegers\Mongodb\Eloquent\Model;

class EloquentLogRepository
    extends BaseEloquentAbstractRepository
    implements LogRepositoryInterface
{

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

}
