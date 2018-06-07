<?php

namespace App\Persistences\Eloquent;


use Exception;
use Jenssegers\Mongodb\Eloquent\Model as Model;

/**
 * Class BaseEloquentAbstractRepository
 * @package App\Persistences\Eloquent
 */
abstract class BaseEloquentAbstractRepository implements BaseEloquentAbstractInterface
{

    protected $model;

    /**
     * BaseEloquentAbstractRepository constructor.
     * @param $model
     * @throws Exception
     */
    public function __construct($model)
    {
        if (($model instanceof Model) === false)
            throw new Exception("Model is invalid");
        $this->model = $model;
    }

    public function all(array $with = [], $limit = 15)
    {
        return $this->model->with($with)->paginate($limit);
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function search($data)
    {
        return $this->model
                 ->whereFullText($data)
                 ->orderBy('score', [ '$meta' => 'textScore' ] )
                 ->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        return $this->model->find($id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }

}
