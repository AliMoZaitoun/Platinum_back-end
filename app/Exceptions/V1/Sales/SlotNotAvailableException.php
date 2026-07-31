<?php

namespace App\Exceptions\V1\Sales;

use Exception;
use Throwable;

class SlotNotAvailableException extends Exception
{
    public function __construct(
        string $messageKey = "messages.appointments.slot_not_available",
        int $code = 422,
        Throwable $previous = null
    ) {
        $message = __($messageKey);

        parent::__construct($message, $code, $previous);
    }
}
