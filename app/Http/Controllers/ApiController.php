<?php

namespace App\Http\Controllers;


use App\Traits\ApiResponse;
use App\Traits\JWTTokenBearerTrait;

class ApiController extends Controller
{

    use JWTTokenBearerTrait;
    use ApiResponse;
}
