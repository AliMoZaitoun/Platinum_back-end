<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ChangePasswordRequest;
use App\Http\Requests\V1\ForgotPasswordRequest;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Requests\V1\RefreshTokenRequest;
use App\Http\Requests\V1\ResetPasswordRequest;
use App\Http\Requests\V1\VerifyEmailRequest;
use App\Services\AuthService;

use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private AuthService $authService
    ) {}

    public function login(LoginRequest $request)
    {
        $data = $this->authService->login($request);
        return $this->successResponse($data);
    }

    public function logout()
    {
        $this->authService->logout();
        return $this->successResponse(null, 'Logged out successfully');
    }

    public function verifyEmail(VerifyEmailRequest $request)
    {
        $data = $this->authService->verifyEmail($request);
        return $this->successResponse($data, 'Email verified successfully');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $this->authService->changePassword($request);
        return $this->successResponse($data, 'Password changed successfully');
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $data = $this->authService->forgotPassword($request);
        return $this->successResponse($data, 'OTP sent to your email');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $this->authService->resetPassword($request);
        return $this->successResponse($data, 'Password changed successfully.');
    }

    public function refreshToken(RefreshTokenRequest $request)
    {
        $newTokens = $this->authService->refreshToken($request->input('refresh_token'));
        return $this->successResponse($newTokens, 'New token generated successfully', 201);
    }
}
