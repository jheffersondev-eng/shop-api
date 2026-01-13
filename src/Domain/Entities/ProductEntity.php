<?php

namespace Src\Domain\Entities;

use DateTime;

class ProductEntity
{
    public function __construct(
        public int $id,
        public string $name,
        public string|null $description,
        public int $categoryId,
        public int $unitId,
        public string $barcode,
        public bool $isActive,
        public float $price,
        public float $costPrice,
        public float $stockQuantity,
        public float $minQuantity,
        public int $ownerId,
        public int|null $userIdCreated,
        public int|null $userIdUpdated,
        public DateTime $createdAt,
        public DateTime $updatedAt
    ) {}
}