<?php

namespace App\Http\Controllers\Auth;

use App\Config\PermissionsConfig;
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

        return $this->errorResponse('Invalid credentials', Response::HTTP_UNAUTHORIZED);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $user->assignRole(PermissionsConfig::USER);

        event(new Registered($user));

        return $this->successResponse($user->createToken($request->get('user_agent'))->plainTextToken);
    }

    public function user(): JsonResponse
    {
        return $this->successResponse(auth()->user());
    }
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $resetStatus = Password::sendResetLink($request->validated());

        $status = $resetStatus === Password::RESET_LINK_SENT;

        if ($status) {
            return $this->successResponse(__($resetStatus));
        }

        return $this->errorResponse(__($resetStatus));
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $resetStatus = Password::reset(
            $request->validated(),
            static function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);

                $user->save();

                event(new PasswordReset($user));
            }
        );

        $status = $resetStatus === Password::PASSWORD_RESET;

        if ($status) {
            return $this->successResponse(__($resetStatus));
        }

        return $this->errorResponse(__($resetStatus));
    }

    public function roles(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $roleNames = $user->getRoleNames();

        return $this->successResponse($roleNames);
    }

    public function permissions(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $permissionNames = $user->getAllPermissions()->pluck('name');

        return $this->successResponse($permissionNames);
    }
}
