<?php

namespace Src\Application\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    public function __construct(string $message = 'Acesso negado.')
    {
        parent::__construct($message);
    }
}
