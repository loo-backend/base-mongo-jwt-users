<?php

namespace App\Repositories\User;

use App\Persistences\Mongodb\BaseMongodbAbstractRepository;
use Jenssegers\Mongodb\Eloquent\Model;

class UserMongodbRepository
    extends BaseMongodbAbstractRepository
    implements UserRepositoryInterface
{

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

    public function search($data)
    {
        return $this->model->whereFullText($data)
            ->orderBy('score', [ '$meta' => 'textScore' ] )
            ->get();
    }

}
