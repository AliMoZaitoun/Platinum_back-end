<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class DeviceMismatchException extends Exception
{
    public function __construct(
        $messageKey = "sentences.device_mismatch",
        $code = 403,
        Throwable $previous = null
    ) {
        $message = __($messageKey);

        parent::__construct($message, $code, $previous);
    }
}
