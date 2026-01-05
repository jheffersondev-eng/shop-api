<?php

namespace Src\Application\Interfaces\Repositories;

use Src\Application\Dto\Product\CreateProductDto;
use Src\Application\Dto\Product\GetProductFilterDto;
use Src\Domain\Entities\ProductSummaryEntity;

interface IProductRepository
{
    public function getProductsByFilter(GetProductFilterDto $getProductFilterDto): array;
    public function getProductImages(int $productId): array;
    public function createProduct(CreateProductDto $createProductDto): array;
    public function createProductImages(int $productId, array $images): array;
    public function deleteProduct(int $productId, int $userId): bool;
    public function deleteProductImage(int $imageId): bool;
    public function updateProduct(int $productId, CreateProductDto $createProductDto): ProductSummaryEntity;
}
