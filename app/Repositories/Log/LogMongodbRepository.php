<?php

namespace App\Repositories\Log;

use App\Persistences\Mongodb\BaseMongodbAbstractRepository;
use Jenssegers\Mongodb\Eloquent\Model;

class LogMongodbRepository
    extends BaseMongodbAbstractRepository
    implements LogRepositoryInterface
{

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

}
