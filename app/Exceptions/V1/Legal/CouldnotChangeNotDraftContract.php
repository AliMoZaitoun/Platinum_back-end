<?php

namespace App\Exceptions\V1\Legal;

use Exception;
use Throwable;

class CouldnotChangeNotDraftContract extends Exception
{
    public function __construct($messageKey = "messages.contract.non_draft_change", $code = 403, Throwable $previous = null)
    {
        $message = __($messageKey);

        parent::__construct($message, $code, $previous);
    }
}
