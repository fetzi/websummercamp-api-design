<?php

namespace App\Exceptions;

use Exception;

class NotAuthorizedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid API token given', 401);
    }
}