<?php

namespace App\Http\Controllers\Privilege;

use App\Http\Controllers\ApiController;
use App\Repositories\Privilege\PrivilegeRepositoryInterface;

/**
 * Class PrivilegeController
 * @package App\Http\Controllers\Privilege
 */
class PrivilegeController extends ApiController
{

    /**
     * @var PrivilegeRepositoryInterface
     */
    private $repository;

    /**
     * PrivilegeController constructor.
     * @param PrivilegeRepositoryInterface $repository
     */
    public function __construct(PrivilegeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->showAll( $this->repository->all() );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->showOne($this->repository->findById($id));
    }

}
