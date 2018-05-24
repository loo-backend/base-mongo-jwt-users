<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Services\User\UserWhereFirstService;
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

        $service = new UserWhereFirstService();
        $user = $service->whereFirst(['email' => strtolower( $request->input('email') )]);

        $factory = JWTFactory::customClaims([
            'sub' => $user
        ]);

        $payload = $factory->make();

        return (string) JWTAuth::encode($payload);

    }

}
