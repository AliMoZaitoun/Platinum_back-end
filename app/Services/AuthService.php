<?php

namespace App\Services;

use App\DAO\OtpCodeDAO;
use App\DAO\RefreshTokenDAO;
use App\DAO\UserDAO;
use App\Exceptions\NotFoundException;
use App\Exceptions\OtpCodeExpiredException;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthService
{
    public function __construct(
        private UserDAO $userDAO,
        private RefreshTokenDAO $refreshTokenDAO,
        private OtpService $otpService
    ) {}

    public function login($credentials)
    {
        $loginType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $credentials = [
            $loginType => $credentials['login'],
            'password' => $credentials['password'],
        ];

        if (!Auth::attempt($credentials)) throw new NotFoundException('User');

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        $permissions = $user->roles
            ->flatMap(fn($role) => $role->permissions->pluck('name'))
            ->unique()
            ->values()
            ->toArray();

        return ['user' => $user, 'token' => $token, 'permissions' => $permissions];
    }

    public function logout()
    {
        return Auth::user()->currentAccessToken()->delete();
    }

    public function verifyEmail($request)
    {
        $email = $request->input('email');
        $code = $request->input('code');
        $user = $this->userDAO->findByEmail($email);

        $this->otpService->verifyCode($user->id, $code);

        return $this->userDAO->verify($user);
    }

    public function changePassword($request)
    {
        $user = Auth::user();
        $currentPassword = $request->input('current_password');
        $newPassword = $request->input('new_password');
        if (!password_verify($currentPassword, $user->password)) {
            return false;
        }
        return $this->userDAO->updatePassword($user, $newPassword);
    }

    public function forgotPassword($request)
    {
        $email = $request->input('email');
        $user = $this->userDAO->findByEmail($email);

        $this->otpService->createCode($user->id);
        return true;
    }

    public function resetPassword($request)
    {
        $email = $request->input('email');
        $code = $request->input('code');
        $newPassword = $request->input('new_password');

        $user = $this->userDAO->findByEmail($email);

        if (!$this->otpService->verifyCode($user->id, $code)) {
            return false;
        }
        return $this->userDAO->updatePassword($user, $newPassword);
    }

    public function refreshToken(string $refreshToken)
    {
        $hashedToken = hash('sha256', $refreshToken);
        $storedToken = $this->refreshTokenDAO->findByToken($hashedToken);

        if (!$storedToken) {
            return false;
        }

        $user = $this->userDAO->findById($storedToken->user_id);
        $access_token = $user->createToken('auth_token')->plainTextToken;

        $plainRefresh  = Str::random(64);
        $hashedRefresh  = hash('sha256', $plainRefresh);
        $this->refreshTokenDAO->update($storedToken, $hashedRefresh);

        $tokens = [
            'access_token' => $access_token,
            'refresh_token' => $plainRefresh,
        ];

        return $tokens;
    }
}
