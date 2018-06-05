<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\ApiController;
use App\Services\Role\RoleAllService;
use App\Services\Role\RoleFindService;
use App\User;

class RoleAdminController extends ApiController
{

    /**
     * @param RoleAllService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(RoleAllService $service)
    {
        return $this->showAll($service->admin()->all());
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
