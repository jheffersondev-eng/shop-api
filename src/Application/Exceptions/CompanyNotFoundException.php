<?php

namespace Src\Application\Exceptions;

use Exception;

class CompanyNotFoundException extends Exception
{
    public function __construct(string $message = 'Empresa não encontrada.')
    {
        parent::__construct($message);
    }
}
