<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use App\Traits\JWTTokenBearerTrait;

/**
 * Class ApiController
 * @package App\Http\Controllers
 */
class ApiController extends Controller
{

    use JWTTokenBearerTrait;
    use ApiResponse;
}
