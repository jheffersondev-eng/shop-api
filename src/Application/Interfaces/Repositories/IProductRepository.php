<?php

namespace Src\Application\Interfaces\Repositories;

use Src\Application\Dto\Product\GetProductFilterDto;

interface IProductRepository
{
    public function getProductsByFilter(GetProductFilterDto $getProductFilterDto): array;
    public function getProductImages(int $productId): array;
}
