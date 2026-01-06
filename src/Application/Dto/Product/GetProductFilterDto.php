<?php

namespace Src\Application\Dto\Product;

use DateTime;

class GetProductFilterDto
{
    public function __construct(
        public readonly int|null $id,
        public readonly int|null $ownerId,
        public readonly string|null $name,
        public readonly int|null $categoryId,
        public readonly int|null $unitId,
        public readonly string|null $barcode,
        public readonly bool|null $isActive,
        public readonly int|null $userIdCreated,
        public readonly DateTime|null $dateDe,
        public readonly DateTime|null $dateAte,
        public readonly int $page = 1,
        public readonly int $pageSize = 10
    ) {}
}
