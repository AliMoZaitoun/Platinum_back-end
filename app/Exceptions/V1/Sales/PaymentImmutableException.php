<?php

namespace App\Exceptions\V1\Sales;

use Exception;
use Throwable;

class PaymentImmutableException extends Exception
{
    public function __construct(
        string $messageKey = "messages.payment.cannot_be_updated",
        int $code = 422,
        Throwable $previous = null
    ) {
        $message = __($messageKey);

        parent::__construct($message, $code, $previous);
    }
}
