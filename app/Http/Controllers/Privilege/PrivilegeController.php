<?php

namespace App\Http\Controllers\Privilege;

use App\Http\Controllers\ApiController;
use App\Services\Privilege\PrivilegeAllService;
use App\Services\Privilege\PrivilegeFindService;

/**
 * Class PrivilegeController
 * @package App\Http\Controllers\Privilege
 */
class PrivilegeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param PrivilegeAllService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PrivilegeAllService $service)
    {
        return $this->showAll($service->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param PrivilegeFindService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id, PrivilegeFindService $service)
    {
        return $this->showOne($service->findBy($id));
    }

}
