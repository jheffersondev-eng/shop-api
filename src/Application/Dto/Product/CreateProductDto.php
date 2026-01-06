<?php

namespace Src\Application\Dto\Product;

class CreateProductDto
{
    public function __construct(
        public readonly string $name,
        public readonly array $images,
        public readonly string $description,
        public readonly int $categoryId,
        public readonly int $unitId,
        public readonly string $barcode,
        public readonly bool $isActive,
        public readonly float $price,
        public readonly float $costPrice,
        public readonly int $stockQuantity,
        public readonly int $minQuantity,
        public readonly int|null $ownerId,
        public readonly int|null $userIdCreated,
        public readonly int|null $userIdUpdated
    ) {}
}
