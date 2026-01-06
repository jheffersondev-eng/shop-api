<?php

namespace Src\Application\Interfaces\Services;

use Src\Application\Dto\Product\CreateProductDto;
use Src\Application\Dto\Product\GetProductFilterDto;
use Src\Application\Services\ServiceResult;

interface IProductService
{
    public function getProductsByFilter(GetProductFilterDto $getProductFilterDto): ServiceResult;
    public function getProductImages(int $productId): ServiceResult;
    public function createProduct(CreateProductDto $createProductDto): ServiceResult;
    public function deleteProduct(int $productId, int $userIdDeleted): ServiceResult;
    public function updateProduct(int $productId, CreateProductDto $createProductDto): ServiceResult;
}
