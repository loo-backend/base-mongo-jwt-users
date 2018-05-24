<?php

namespace App\Http\Controllers;

use App\Factories\JWTTokenBearerFactory;
use App\Services\User\UserFindService;
use App\Services\User\UserRemoveService;
use App\Services\User\UserUpdateService;
use App\Services\User\Tenant\UserCreateTenantService;
use App\Services\User\Tenant\UserTenantAllService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;

/**
 * Class UsersTenantController
 * @package App\Http\Controllers
 */
class UsersTenantController extends Controller
{


    /**
     * @var UserCreateTenantService
     */
    private $createService;

    /**
     * @var UserFindService
     */
    private $findService;

    /**
     * @var UserTenantAllService
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
     * @var JWTTokenBearerFactory
     */
    private $bearerFactory;


    /**
     * UsersController constructor.
     * @param UserCreateTenantService $createService
     * @param UserFindService $findService
     * @param UserTenantAllService $allService
     * @param UserRemoveService $removeService
     * @param UserUpdateService $updateService
     * @param JWTTokenBearerFactory $bearerFactory
     */
    public function __construct(
        UserCreateTenantService $createService,
        UserFindService $findService,
        UserTenantAllService $allService,
        UserRemoveService $removeService,
        UserUpdateService $updateService,
        JWTTokenBearerFactory $bearerFactory
    ) {

        $this->createService = $createService;
        $this->findService = $findService;
        $this->allService = $allService;
        $this->removeService = $removeService;
        $this->updateService = $updateService;
        $this->bearerFactory = $bearerFactory;
    }


    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {

        $result = $this->allService->all();

        if (count($result) <= 0) {

            return response()->json(['error' => 'users_not_found'], 422);
        }

        return response()->json($result, 200);

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
            return response()->json(['error' => 'user_not_created'], 500);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'data' => '',
                'error' => 'invalid_credentials'
            ], 401);
        }

        $token = $this->bearerFactory->generate($request);

        //Authorization || HTTP_Authorization
        return response()->json([
            'success' => true,
            'HTTP_Authorization' => $token
        ], 200);


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return bool
     * @throws \Exception
     */
    public function show($id)
    {

        if (!$result = $this->findService->findBy($id)) {
            return response()->json(['error' => 'user_not_found'], 422);
        }

        return response()->json($result, 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $validator = $this->updateService->validator($request->all(), intval($id));

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $errors->toJson();
        }


        if (!$result = $this->findService->findBy($id)) {
            return response()->json(['error' => 'user_not_found'], 422);
        }

        if (!$result = $this->updateService->update($request, $id)) {

            return response()->json(['error' => 'user_not_updated'], 422);
        }

        return response()->json($result, 200);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
//    public function destroy($id)
//    {
//
//        if (!$result = $this->findService->findBy($id)) {
//            return response()->json(['error' => 'user_not_found'], 422);
//        }
//
//        if (!$result = $this->removeService->remove($id)) {
//
//            return response()->json(['error' => 'user_not_removed'], 422);
//        }
//
//        return response()->json(['response' => 'user_removed'], 200);
//
//    }

}
