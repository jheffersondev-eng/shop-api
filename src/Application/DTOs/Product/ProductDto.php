<?php

namespace Src\Application\DTOs\Product;

class ProductDto
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}
