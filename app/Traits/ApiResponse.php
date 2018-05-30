<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait ApiResponse
 * @package App\Traits
 */
trait ApiResponse
{

    /**
     * @param $data
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, $code=200)
    {
        return response()->json(['data' => $data], $code);
    }

    /**
     * @param $message
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }


    /**
     * @param $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showAll($data, $code = 200)
    {
        return response()->json($data, $code);
    }

    /**
     * @param $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showOne($data, $code = 200)
    {
        return $this->successResponse($data, $code);
    }

}
