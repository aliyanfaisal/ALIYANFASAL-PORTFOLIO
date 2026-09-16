<?php

namespace App\Exceptions;

use RuntimeException;

class LinkedInApiException extends RuntimeException
{
    /**
     * @param  array<string, mixed>|string  $responseBody
     */
    public function __construct(
        string $message,
        public readonly int $status,
        public readonly array|string $responseBody,
    ) {
        parent::__construct($message);
    }
}
