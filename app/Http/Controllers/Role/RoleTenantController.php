<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\ApiController;
use App\Services\Role\RoleService;
use App\Services\Role\RoleFindService;
use App\Entities\User;

class RoleTenantController extends ApiController
{

    /**
     * @param RoleService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(RoleService $service)
    {
        return $this->showAll($service->tenant()->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param RoleFindService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id, RoleFindService $service)
    {
        return $this->showOne( $service->findBy($id) );
    }


}
