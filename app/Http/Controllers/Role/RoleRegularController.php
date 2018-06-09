<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\ApiController;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Services\Role\RoleService;

class RoleRegularController extends ApiController
{

    /**
     * @var RoleRepositoryInterface
     */
    private $repository;

    /**
     * @var RoleService
     */
    private $service;

    /**
     * RoleAdminController constructor.
     * @param RoleRepositoryInterface $repository
     * @param RoleService $service
     */
    public function __construct(RoleRepositoryInterface $repository,
                                RoleService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->showAll( $this->service->tenant()->all() );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->showOne( $this->repository->findById($id) );
    }

}
