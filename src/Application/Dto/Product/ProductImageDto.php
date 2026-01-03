<?php

namespace Src\Application\Dto\Product;

use DateTime;

class ProductImageDto
{
    public function __construct(
        public int|null $id,
        public int|null $productId,
        public string|null $image,
    ) {}
}
