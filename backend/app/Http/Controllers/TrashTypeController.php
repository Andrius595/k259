<?php

namespace App\Http\Controllers;

use App\Models\TrashType;
use Illuminate\Http\JsonResponse;

class TrashTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $trashTypes = TrashType::all();

        return $this->successResponse($trashTypes);
    }
}
