<?php

namespace App\Exceptions\V1\Legal;

use Exception;
use Throwable;

class ContractNotPending extends Exception
{
    public function __construct($messageKey = "messages.contract.contract_not_pending", $code = 422, Throwable $previous = null)
    {
        $message = __($messageKey);

        parent::__construct($message, $code, $previous);
    }
}
