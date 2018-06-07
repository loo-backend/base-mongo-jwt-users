<?php

namespace App\Repositories\Log;

use App\Entities\Log\LogRepository;
use App\Persistences\Eloquent\BaseEloquentAbstractRepository;
use Jenssegers\Mongodb\Eloquent\Model;

class LogRepositoryEloquent
    extends BaseEloquentAbstractRepository
    implements LogRepository
{

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

}
