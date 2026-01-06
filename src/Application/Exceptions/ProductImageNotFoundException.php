<?php

namespace Src\Application\Exceptions;

use Exception;

class ProductImageNotFoundException extends Exception
{
    public function __construct(string $message = 'Imagem do produto não encontrada.')
    {
        parent::__construct($message);
    }
}
