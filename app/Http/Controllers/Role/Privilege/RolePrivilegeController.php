<?php

namespace App\Http\Controllers\Role\Privilege;

use App\Http\Controllers\ApiController;
use App\Services\Role\Privilege\RolePrivilegeAllService;
use App\Services\Role\Privilege\RolePrivilegeFindService;


class RolePrivilegeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param RolePrivilegeAllService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(RolePrivilegeAllService $service)
    {
        return $this->showAll($service->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param RolePrivilegeFindService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id, RolePrivilegeFindService $service)
    {
        return $this->showOne($service->findBy($id));
    }

}
