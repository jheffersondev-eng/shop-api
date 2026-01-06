<?php

namespace Src\Application\Exceptions;

use Exception;

class UnitNotFoundException extends Exception
{
    public function __construct(string $message = 'Unidade não encontrada.')
    {
        parent::__construct($message);
    }
}
