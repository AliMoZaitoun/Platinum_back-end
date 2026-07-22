<?php

namespace App\Exceptions\V1\Engineer\Report;

use Exception;
use Throwable;

class EngineerNotCheckedInException extends Exception
{
    public function __construct(
        string $messageKey = "messages.attendance.not_checked_in_yet_report",
        int $code = 422,
        Throwable $previous = null
    ) {
        $message = __($messageKey);

        parent::__construct($message, $code, $previous);
    }
}
