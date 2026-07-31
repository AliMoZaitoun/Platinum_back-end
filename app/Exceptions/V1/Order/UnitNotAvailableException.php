<?php

namespace App\Exceptions\V1\Order;

use Exception;
use Throwable;

class UnitNotAvailableException extends Exception
{
    public function __construct($messageKey = "messages.orders.unit_not_available", $code = 422, Throwable $previous = null)
    {
        $message = __($messageKey);

        parent::__construct($message, $code, $previous);
    }
}
