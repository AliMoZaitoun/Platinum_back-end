<?php

namespace App\Exceptions;

class OtpCodeExpiredException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct("OTP Code expired.", 403);
    }
}
