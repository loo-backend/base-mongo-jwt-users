<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Services\User\UserFindService;
use App\Services\User\UserRemoveService;
use App\Services\User\UserUpdateService;
use App\Services\User\Admin\UserAdminAllService;
use App\Services\User\Admin\UserCreateAdminService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;


class UsersAdminController extends ApiController
{


    /**
     * @var UserCreateAdminService
     */
    private $createAdminService;

    /**
     * @var UserFindService
     */
    private $findService;

    /**
     * @var UserAdminAllService
     */
    private $allService;

    /**
     * @var UserRemoveService
     */
    private $removeService;

    /**
     * @var UserUpdateService
     */
    private $updateService;

    /**
     * UsersController constructor.
     * @param UserCreateAdminService $createAdminService
     * @param UserFindService $findService
     * @param UserAdminAllService $allService
     * @param UserRemoveService $removeService
     * @param UserUpdateService $updateService
     */
    public function __construct(
        UserCreateAdminService $createAdminService,
        UserFindService $findService,
        UserAdminAllService $allService,
        UserRemoveService $removeService,
        UserUpdateService $updateService
    ) {

        $this->createAdminService = $createAdminService;
        $this->findService = $findService;
        $this->allService = $allService;
        $this->removeService = $removeService;
        $this->updateService = $updateService;
    }


    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {

        $result = $this->allService->all();

        if (count($result) <= 0) {

            return $this->errorResponse('users_not_found', 422);
        }

        return $this->showAll($result);

    }

    /**
     *
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|Response
     * @throws \Exception
     */
    public function store(Request $request)
    {

        $validator = $this->createAdminService->validator($request->all());

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $errors->toJson();
        }

        if (!$result = $this->createAdminService->create($request)) {

            return $this->errorResponse('user_not_created', 500);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {

            $error = [
                'success' => false,
                'data' => '',
                'error' => 'invalid_credentials'
            ];

            return $this->errorResponse($error, 401);

        }

        $token = $this->tokenBearerGenerate($request);

        //Authorization || HTTP_Authorization
        $success = [
            'success' => true,
            'HTTP_Authorization' => $token
        ];

        return $this->successResponse($success);

    }


    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {

        if (!$result = $this->findService->findBy($id)) {
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

        if (!$result = $this->findService->findBy($id)) {
            return $this->errorResponse('user_not_found', 422);
        }

        if (!$result = $this->updateService->update($request, $id)) {
            return $this->errorResponse('user_not_updated', 422);
        }

        return $this->successResponse($result);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {

        if (!$result = $this->findService->findBy($id)) {
            return $this->errorResponse('user_not_found', 422);
        }

        if (!$result = $this->removeService->remove($id)) {

            return $this->errorResponse('user_not_removed', 422);
        }

        return $this->successResponse('user_removed');

    }

}
