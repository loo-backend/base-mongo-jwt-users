<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\ApiController;
use App\Services\Role\RoleAllService;
use App\Services\Role\RoleFindService;
use App\User;

class RoleTenantController extends ApiController
{

    /**
     * @param RoleAllService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(RoleAllService $service)
    {
        return $this->showAll($service->all(User::REGULAR_USER));
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
