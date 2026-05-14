<?php

namespace App\Services;

use App\DAO\OtpCodeDAO;
use App\DAO\UserDAO;
use App\Exceptions\OtpCodeExpiredException;

class OtpService
{

    public function __construct(
        private OtpCodeDAO $otpCodeDAO,
        private UserDAO $userDAO
    ) {}

    public function generateCode()
    {
        return rand(100000, 999999);
    }

    public function createCode(int $userId)
    {
        $code = $this->generateCode();
        $this->otpCodeDAO->store($userId, $code);
        return $code;
    }

    public function verifyCode(int $userId, $code)
    {
        $code = $this->otpCodeDAO->findValidCode($userId, $code);
        if (!$code)
            throw new OtpCodeExpiredException();

        $this->otpCodeDAO->deleteCodes($userId);
        return true;
    }

    public function resendCode(string $email)
    {
        $user = $this->userDAO->findByEmail($email);
        $this->otpCodeDAO->deleteCodes($user->id);
        return $this->createCode($user->id);
    }
}
