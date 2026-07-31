<?php

namespace App\Exceptions\V1\Sales;

use Exception;
use Throwable;

class CannotCancelAppointmentException extends Exception
{
    public function __construct(
        string $messageKey = "messages.appointments.cannot_cancel_late",
        int $code = 422,
        Throwable $previous = null
    ) {
        $message = __($messageKey);

        parent::__construct($message, $code, $previous);
    }
}
