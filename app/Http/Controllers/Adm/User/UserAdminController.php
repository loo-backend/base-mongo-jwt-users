<?php

namespace App\Http\Controllers\Adm\User;

use App\Http\Controllers\ApiController;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Adm\User\Admin\UserAdminCreateService;
use App\Services\Adm\User\Admin\UserAdminGetAllService;
use App\Services\Adm\User\Admin\UserAdminUpdateService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class UserAdminController
 * @package App\Http\Controllers
 */
class UserAdminController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UserAdminUpdateService
     */
    private $updateService;

    /**
     * @var UserAdminCreateService
     */
    private $createService;

    /**
     * @var UserAdminGetAllService
     */
    private $getAllService;


    /**
     * UserAdminController constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserAdminUpdateService $updateService
     * @param UserAdminCreateService $createService
     * @param UserAdminGetAllService $getAllService
     */
    public function __construct(UserRepositoryInterface $userRepository,
                                UserAdminUpdateService $updateService,
                                UserAdminCreateService $createService,
                                UserAdminGetAllService $getAllService)
    {


        $this->userRepository = $userRepository;
        $this->updateService = $updateService;
        $this->createService = $createService;
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
     *
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|Response
     * @throws \Exception
     */
    public function store(Request $request)
    {

        $validator = $this->createService->validator($request->all());

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $errors->toJson();
        }

        if (!$result = $this->createService->create($request)) {

            return $this->errorResponse('user_not_created', 500);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {

            return $this->errorResponse('invalid_credentials', 401);

        }

        //Authorization || HTTP_Authorization
        return $this->successResponse([
            'HTTP_Authorization' => $this->tokenBearerGenerate($request)
        ]);

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

        $validator = $this->updateService->validator($request->all(), $id);

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

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {

        if (!$result = $this->userRepository->findById($id)) {
            return $this->errorResponse('user_not_found', 422);
        }

        if (!$result = $this->userRepository->delete($id)) {
            return $this->errorResponse('user_not_removed', 422);
        }

        return $this->successResponse('user_removed');

    }

}
