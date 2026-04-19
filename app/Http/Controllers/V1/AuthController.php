<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ChangePasswordRequest;
use App\Http\Requests\V1\ForgotPasswordRequest;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Requests\V1\RefreshTokenRequest;
use App\Http\Requests\V1\ResetPasswordRequest;
use App\Http\Requests\V1\VerifyEmailRequest;
use App\Services\User\AuthService;
use App\Traits\ProvidesUserResource;
use App\Traits\ResponseTrait;

class AuthController extends Controller
{
    use ResponseTrait, ProvidesUserResource;
    public function __construct(
        private AuthService $authService
    ) {}

    public function login(LoginRequest $request)
    {
        $data = $this->authService->login($request);
        $data['user'] = $this->resolveUserResource($data['user']);
        return $this->successResponse($data);
    }

    public function logout()
    {
        $this->authService->logout();
        return $this->successResponse(null, __('messages.auth.logout'));
    }

    public function verifyEmail(VerifyEmailRequest $request)
    {
        $data = $this->authService->verifyEmail($request);
        return $this->successResponse($data, __('messages.auth.email_verified'));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $this->authService->changePassword($request);
        return $this->successResponse([], __('messages.auth.password_changed'));
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $data = $this->authService->forgotPassword($request);
        return $this->successResponse($data, __('messages.auth.otp_sent'));
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $this->authService->resetPassword($request);
        return $this->successResponse($data, __('messages.auth.password_changed'));
    }

    public function refreshToken(RefreshTokenRequest $request)
    {
        $newTokens = $this->authService->refreshToken($request->input('refresh_token'));
        return $this->successResponse($newTokens, code: 201);
    }
}
