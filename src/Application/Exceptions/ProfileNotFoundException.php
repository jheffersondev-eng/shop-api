<?php

namespace Src\Application\Exceptions;

use Exception;

class ProfileNotFoundException extends Exception
{
    public function __construct(string $message = 'Perfil não encontrado.')
    {
        parent::__construct($message);
    }
}
