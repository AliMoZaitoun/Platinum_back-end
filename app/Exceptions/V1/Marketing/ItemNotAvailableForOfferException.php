<?php

namespace App\Exceptions\V1\Marketing;

use Exception;
use Throwable;

class ItemNotAvailableForOfferException extends Exception
{
    public function __construct($messageKey = "messages.offer.item_not_available", $code = 400, Throwable $previous = null)
    {
        $message = __($messageKey);

        parent::__construct($message, $code, $previous);
    }
}
