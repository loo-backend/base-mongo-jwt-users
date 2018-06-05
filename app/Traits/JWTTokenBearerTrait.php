<?php

namespace App\Traits;

use App\Services\Auth\UserAuthenticateService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

/**
 * Trait JWTTokenBearerTrait
 * @package App\Traits
 */
trait JWTTokenBearerTrait {


    /**
     * @param Request $request
     * @return string
     */
    public function tokenBearerGenerate(Request $request)
    {

        $service = new UserAuthenticateService();
        $user = $service->authenticate(['email' => strtolower( $request->input('email') )]);

        $factory = JWTFactory::customClaims([
            'sub' => $user
        ]);

        $payload = $factory->make();

        return (string) JWTAuth::encode($payload);

    }

}
