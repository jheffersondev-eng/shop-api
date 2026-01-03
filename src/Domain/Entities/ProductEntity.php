<?php

namespace Src\Domain\Entities;

use DateTime;

class ProductEntity
{
    public function __construct(
        public int $id,
        public string $name,
        public array $images,
        public CategorySummaryEntity $category,
        public UnitSummaryEntity $unit,
        public string $barcode,
        public bool $isActive,
        public float $price,
        public float $costPrice,
        public float $stockQuantity,
        public float $minQuantity,
        public UserSummaryEntity $owner,
        public UserSummaryEntity $userCreated,
        public UserSummaryEntity $userUpdated,
        public DateTime $createdAt,
        public DateTime $updatedAt
    ) {}
}