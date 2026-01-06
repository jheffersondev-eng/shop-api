<?php

namespace Src\Application\Exceptions;

use Exception;

class ProductNotFoundException extends Exception
{
    public function __construct(string $message = 'Produto não encontrado.')
    {
        parent::__construct($message);
    }
}
