<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $updated = $user->update($request->validated());

        if ($updated) {
            return $this->successResponse();
        }

        return $this->errorResponse();
    }

    public function getPointsLeaderboard(): JsonResponse
    {
        $users = User::query()->orderBy('points', 'desc')->take(10)->get();

        return $this->successResponse($users);
    }
}
