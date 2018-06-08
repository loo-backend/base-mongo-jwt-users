<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\User\UserIndexService;
use App\Services\User\UserStoreService;
use App\Services\User\UserUpdateService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

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
     * @var UserUpdateService
     */
    private $updateService;

    /**
     * @var UserStoreService
     */
    private $storeService;

    /**
     * @var UserIndexService
     */
    private $indexService;

    /**
     * UserAdminController constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserUpdateService $updateService
     * @param UserStoreService $storeService
     * @param UserIndexService $indexService
     */
    public function __construct(UserRepositoryInterface $userRepository,
                                UserUpdateService $updateService,
                                UserStoreService $storeService,
                                UserIndexService $indexService)
    {

        $this->userRepository = $userRepository;
        $this->updateService = $updateService;
        $this->storeService = $storeService;
        $this->indexService = $indexService;

    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {

        if (!$result = $this->indexService->tenant()->all()) {
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

        $validator = $this->storeService->validator($request->all());

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $errors->toJson();
        }

        if (!$result = $this->storeService->tenant()->store($request)) {

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
