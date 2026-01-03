<?php

namespace Src\Application\Dto\Product;

use DateTime;

class GetProductFilterDto
{
    public function __construct(
        public int|null $id,
        public int|null $ownerId,
        public string|null $name,
        public int|null $categoryId,
        public int|null $unitId,
        public string|null $barcode,
        public bool|null $isActive,
        public int|null $userIdCreated,
        public DateTime|null $dateDe,
        public DateTime|null $dateAte,
        public int $page = 1,
        public int $pageSize = 10
    ) {}
}
