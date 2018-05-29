<?php

namespace App\Http\Controllers\Role;

use App\Services\Roles\RoleAllService;
use App\Services\Roles\RoleFindService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class RoleAdminController extends ApiController
{

    /**
     * @param RoleAllService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(RoleAllService $service)
    {
        return $this->showAll($service->all(User::ADMIN_USER));
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
