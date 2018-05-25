<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Traits\JWTTokenBearerTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthApiController extends ApiController
{

    use JWTTokenBearerTrait;

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

}
