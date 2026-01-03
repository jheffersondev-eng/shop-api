<?php

namespace Src\Application\Interfaces\Services;

use Src\Application\Dto\Product\GetProductFilterDto;
use Src\Application\Services\ServiceResult;

interface IProductService
{
    public function getProductsByFilter(GetProductFilterDto $getProductFilterDto): ServiceResult;
    public function getProductImages(int $productId): ServiceResult;
}
