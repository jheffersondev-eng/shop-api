<?php

namespace Src\Domain\Entities;

use DateTime;

class ProductImageEntity
{
    public function __construct(
        public int $id,
        public int $productId,
        public string $image,
        public DateTime $createdAt,
        public DateTime|null $updatedAt,
        public DateTime|null $deletedAt,
    ) {}
}