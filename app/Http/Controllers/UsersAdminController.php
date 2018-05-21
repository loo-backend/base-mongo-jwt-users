<?php

namespace App\Http\Controllers;

use App\Factories\JWTTokenBearerFactory;
use App\Services\UserAdminAllService;
use App\Services\UserCreateAdminService;
use App\Services\UserFindService;
use App\Services\UserRemoveService;
use App\Services\UserUpdateService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use JWTAuth;
use Validator;


class UsersAdminController extends Controller
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
     * @var JWTTokenBearerFactory
     */
    private $bearerFactory;


    /**
     * UsersController constructor.
     * @param UserCreateAdminService $createAdminService
     * @param UserFindService $findService
     * @param UserAdminAllService $allService
     * @param UserRemoveService $removeService
     * @param UserUpdateService $updateService
     * @param JWTTokenBearerFactory $bearerFactory
     */
    public function __construct(
        UserCreateAdminService $createAdminService,
        UserFindService $findService,
        UserAdminAllService $allService,
        UserRemoveService $removeService,
        UserUpdateService $updateService,
        JWTTokenBearerFactory $bearerFactory
    ) {

        $this->createAdminService = $createAdminService;
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


        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|confirmed|min:6|max:255'
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors();
            return $errors->toJson();
        }


        if (!$result = $this->createAdminService->create($request)) {

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

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                Rule::unique('users', '_id')->ignore($id),
            ],
            'password' => 'sometimes|required|confirmed|min:6|max:255'
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors();
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
    public function destroy($id)
    {

        if (!$result = $this->findService->findBy($id)) {
            return response()->json(['error' => 'user_not_found'], 422);
        }

        if (!$result = $this->removeService->remove($id)) {

            return response()->json(['error' => 'user_not_removed'], 422);
        }

        return response()->json(['response' => 'user_removed'], 200);

    }

}
