<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class OutOfGeofenceException extends Exception
{
    public function __construct(
        int $distance,
        $messageKey = "messages.sentences.out_of_geofence",
        $code = 422,
        Throwable $previous = null
    ) {
        $message = __($messageKey, ['distance' => $distance]);

        parent::__construct($message, $code, $previous);
    }
}
