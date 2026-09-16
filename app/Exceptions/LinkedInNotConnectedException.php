<?php

namespace App\Exceptions;

use RuntimeException;

class LinkedInNotConnectedException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('LinkedIn not connected — visit /auth/linkedin first.');
    }
}
