<?php

namespace Src\Application\Reponses\Product;

use Carbon\Carbon;
use Src\Application\Reponses\Category\CategorySummaryResponseDto;
use Src\Application\Reponses\Unit\UnitSummaryResponseDto;
use Src\Application\Reponses\User\UserDetailSummaryResponseDto;

class GetProductsByFilterResponseDto
{
    public function __construct(
        public int $id,
        public string $name,
        public string|null $description,
        public array $images,
        public CategorySummaryResponseDto $category,
        public UnitSummaryResponseDto $unit,
        public string $barcode,
        public bool $isActive,
        public float $price,
        public float $costPrice,
        public float $stockQuantity,
        public float $minQuantity,
        public UserDetailSummaryResponseDto $owner,
        public UserDetailSummaryResponseDto|null $userCreated,
        public UserDetailSummaryResponseDto|null $userUpdated,
        public UserDetailSummaryResponseDto|null $userDeleted,
        public Carbon $createdAt,
        public Carbon|null $updatedAt,
        public Carbon|null $deletedAt,
    ) {}
}