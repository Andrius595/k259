<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function successResponse($data = null, $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json(['status' => true, 'data' => $data], $status);
    }

    public function errorResponse($data = null, $status = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json(['status' => false, 'data' => $data], $status);
    }
}
