<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Services\Adm\User\Tenant\CreateUserTenantService;
use App\Traits\JWTTokenBearerTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthApiController extends ApiController
{

    use JWTTokenBearerTrait;

    /**
     * @var CreateUserTenantService
     */
    private $createService;


    /**
     * AuthApiController constructor.
     * @param CreateUserTenantService $createService
     */
    public function __construct(CreateUserTenantService $createService)
    {
        $this->createService = $createService;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function authenticate(Request $request)
    {

        // grab credentials from the request
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function register(Request $request)
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

}
