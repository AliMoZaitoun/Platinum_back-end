<?php

namespace App\Exceptions\V1\Lottery;

use Exception;
use Throwable;

class NoEligibleParticipantsException extends Exception
{
    public function __construct(
        string $messageKey = "messages.lottery.no_participants",
        int $code = 422,
        Throwable $previous = null
    ) {
        $message = __($messageKey);

        parent::__construct($message, $code, $previous);
    }
}
