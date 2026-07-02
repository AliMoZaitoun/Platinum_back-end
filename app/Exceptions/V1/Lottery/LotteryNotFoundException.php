<?php

namespace App\Exceptions\V1\Lottery;

use Exception;
use Throwable;

class LotteryNotFoundException extends Exception
{
    public function __construct(
        string $messageKey = "messages.lottery.not_found",
        int $code = 404,
        Throwable $previous = null
    ) {
        $message = __($messageKey);

        parent::__construct($message, $code, $previous);
    }
}
