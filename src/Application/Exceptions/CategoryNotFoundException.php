<?php

namespace Src\Application\Exceptions;

use Exception;

class CategoryNotFoundException extends Exception
{
    public function __construct(string $message = 'Categoria não encontrada.')
    {
        parent::__construct($message);
    }
}
