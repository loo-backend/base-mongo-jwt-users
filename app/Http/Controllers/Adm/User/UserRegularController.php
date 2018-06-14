<?php

namespace App\Http\Controllers\Adm\User;

use App\Http\Controllers\ApiController;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Adm\User\Regular\GetAllUserRegularService;
use App\Services\Adm\User\Regular\UpdateUserRegularService;
use Illuminate\Http\Request;

/**
 * Class UserRegularController
 * @package App\Http\Controllers
 */
class UserRegularController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UpdateUserRegularService
     */
    private $updateService;

    /**
     * @var GetAllUserRegularService
     */
    private $getAllService;

    /**
     * UserRegularController constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UpdateUserRegularService $updateService
     * @param GetAllUserRegularService $getAllService
     */
    public function __construct(UserRepositoryInterface $userRepository,
                                UpdateUserRegularService $updateService,
                                GetAllUserRegularService $getAllService)
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
