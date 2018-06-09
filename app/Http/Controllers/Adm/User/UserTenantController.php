<?php

namespace App\Http\Controllers\Adm\User;

use App\Http\Controllers\ApiController;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Adm\User\Tenant\UserTenantGetAllService;
use App\Services\Adm\User\Tenant\UserTenantUpdateService;
use Illuminate\Http\Request;

/**
 * Class UserTenantController
 * @package App\Http\Controllers
 */
class UserTenantController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UserTenantUpdateService
     */
    private $updateService;

    /**
     * @var UserTenantGetAllService
     */
    private $getAllService;

    /**
     * UserTenantController constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserTenantUpdateService $updateService
     * @param UserTenantGetAllService $getAllService
     */
    public function __construct(UserRepositoryInterface $userRepository,
                                UserTenantUpdateService $updateService,
                                UserTenantGetAllService $getAllService)
    {

        $this->userRepository = $userRepository;
        $this->updateService = $updateService;
        $this->getAllService = $getAllService;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {

        if (!$result = $this->getAllService->getAll()) {
            return $this->errorResponse('users_not_found', 422);
        }

        return $this->showAll($result);

    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {

        if (!$result = $this->userRepository->findById($id)) {
            return $this->errorResponse('user_not_found', 422);
        }

        return $this->showOne($result);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

        $validator = $this->updateService->validator($request->all(), intval($id));

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $errors->toJson();
        }

        if (!$result = $this->userRepository->findById($id)) {
            return $this->errorResponse('user_not_found', 422);
        }

        if (!$result = $this->updateService->update($request, $id)) {
            return $this->errorResponse('user_not_updated', 422);
        }

        return $this->successResponse($result);

    }

}
