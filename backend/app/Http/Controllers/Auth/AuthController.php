<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->get('email'))->first();

        if (Hash::check($request->get('password'), $user->password)) {
            return $this->successResponse($user->createToken($request->get('user_agent'))->plainTextToken);
        }

        return $this->errorResponse();
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        event(new Registered($user));

        return $this->successResponse($user->createToken($request->get('user_agent'))->plainTextToken);
    }

    public function user(): JsonResponse
    {
        return $this->successResponse(auth()->user());
    }
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $status = Password::sendResetLink($request->validated());

        return response()->json(
            ['status' => __($status)],
            $status === Password::RESET_LINK_SENT
                ? Response::HTTP_OK
                : Response::HTTP_BAD_REQUEST
        );
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $status = Password::reset(
            $request->validated(),
            static function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return response()->json(
            ['status' => __($status)],
            $status === Password::PASSWORD_RESET
                ? Response::HTTP_OK
                : Response::HTTP_BAD_REQUEST
        );
    }
}
