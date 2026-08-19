<?php

namespace App\Exceptions\V1\Chat;

use Exception;
use Throwable;

class FaqNodeNotFoundException extends Exception
{
    public function __construct($messageKey = "messages.faq.not_found", $code = 404, Throwable $previous = null)
    {
        $message = __($messageKey);

        parent::__construct($message, $code, $previous);
    }
}
