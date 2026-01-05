<?php

namespace Src\Domain\Entities;

class ProductSummaryEntity
{
    public function __construct(
        public int $id,
        public string $name,
        public string|null $description,
        public int $ownerId,
        public int $categoryId,
        public int $unitId,
        public string $barcode,
        public bool $isActive,
        public float $price,
        public float $costPrice,
        public int $stockQuantity,
        public int $minQuantity,
        public int $userIdCreated,
        public int|null $userIdUpdated,
        public string $createdAt,
        public string $updatedAt,
    ) {}
}
