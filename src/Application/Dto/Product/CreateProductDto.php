<?php

namespace Src\Application\Dto\Product;

class CreateProductDto
{
    public function __construct(
        public int $ownerId,
        public string $name,
        public array $images,
        public string $description,
        public int $categoryId,
        public int $unitId,
        public string $barcode,
        public bool $isActive,
        public float $price,
        public float $costPrice,
        public int $stockQuantity,
        public int $minQuantity,
        public int $userIdCreated
    ) {}
}
