<?php

namespace App\Exceptions\V1\Legal;

use Exception;
use Throwable;

class MissingAppointmentException extends Exception
{
    public function __construct($messageKey = "messages.contract.missing_appointment_exception", $code = 422, Throwable $previous = null)
    {
        $message = __($messageKey);

        parent::__construct($message, $code, $previous);
    }
}
