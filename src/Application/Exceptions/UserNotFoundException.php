<?php

namespace Src\Application\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    public function __construct(string $message = 'Usuário não encontrado.')
    {
        parent::__construct($message);
    }
}
