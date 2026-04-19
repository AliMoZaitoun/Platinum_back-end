<?php

namespace App\Services;

use App\DAO\OtpCodeDAO;
use App\Exceptions\OtpCodeExpiredException;

class OtpService
{

    public function __construct(
        private OtpCodeDAO $otpCodeDAO
    ) {}

    public function generateCode()
    {
        return rand(100000, 999999);
    }

    public function createCode($userId)
    {
        $code = $this->generateCode();
        $this->otpCodeDAO->store($userId, $code);
        return $code;
    }

    public function verifyCode($userId, $code)
    {
        $code = $this->otpCodeDAO->findValidCode($userId, $code);
        if (!$code)
            throw new OtpCodeExpiredException();

        $this->otpCodeDAO->deleteCodes($userId);
        return true;
    }

    public function resendCode($userId)
    {
        $this->otpCodeDAO->deleteCodes($userId);
        return $this->createCode($userId);
    }
}
