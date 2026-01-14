<?php

namespace Src\Application\Interfaces\Services;

use Src\Application\Dto\Product\CreateProductDto;
use Src\Application\Dto\Product\GetProductFilterDto;
use Src\Application\Services\ServiceResult;

interface IProductService
{
    public function getProductsByFilter(GetProductFilterDto $getProductFilterDto): ServiceResult;
    public function create(CreateProductDto $createProductDto): ServiceResult;
    public function delete(int $productId, int $userIdDeleted): ServiceResult;
    public function update(int $productId, CreateProductDto $createProductDto): ServiceResult;
}
