<?php

namespace App\Exceptions\V1\Order;

use Exception;
use Throwable;

class OrderNotApprovedForAppointmentException extends Exception
{
    public function __construct($messageKey = "messages.orders.not_approved_for_appointment", $code = 422, Throwable $previous = null)
    {
        $message = __($messageKey);

        parent::__construct($message, $code, $previous);
    }
}
