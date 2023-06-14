<?php

namespace Markix\Laravel\Exceptions;

use InvalidArgumentException;

final class TokenMissing extends InvalidArgumentException
{
    /**
     * Create a new TokenMissing Exception instance.
     */
    public static function create(): self
    {
        return new self(
            'The Markix API key is missing. Please set the MARKIX_TOKEN variable in your application\'s .env file.'
        );
    }
}
