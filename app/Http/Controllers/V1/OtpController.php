<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\OtpService;

class OtpController extends Controller
{
    public function __construct(
        private OtpService $otpService
    ) {}

    public function resendCode($userId)
    {
        $otpCode = $this->otpService->resendCode($userId);
        return response()->json(['message' => 'OTP resent successfully', 'otp_code' => $otpCode]);
    }
}
