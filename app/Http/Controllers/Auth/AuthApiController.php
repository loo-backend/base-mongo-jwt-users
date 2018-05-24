<?php

namespace App\Http\Controllers\Auth;

use App\Traits\JWTTokenBearerTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;

class AuthApiController extends Controller
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

            return response()->json([
                'success' => false,
                'error' => 'invalid_credentials'
            ], 401);
        }

        $token = $this->tokenBearerGenerate($request);

        //Authorization || HTTP_Authorization
        return response()->json([
            'success' => true,
            'HTTP_Authorization' => $token
        ], 200);

    }

}
