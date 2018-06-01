<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\ApiController;
use App\Services\Role\RolePrivilegeService;
use App\Services\Role\RoleFindService;
use App\User;

class RolePrivilegeController extends ApiController
{

    /**
     * @param RolePrivilegeService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(RolePrivilegeService $service)
    {

        return $this->showAll($service->rolePrivileges(User::ADMIN_USER));
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
