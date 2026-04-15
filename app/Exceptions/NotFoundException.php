<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends \RuntimeException
{
    public function __construct($entity = "Resource")
    {
        parent::__construct("{$entity} not found", 404);
    }
}
