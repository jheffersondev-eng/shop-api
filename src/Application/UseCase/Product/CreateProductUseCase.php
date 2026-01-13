<?php

namespace Src\Application\UseCase\Product;

use Src\Application\Dto\Product\CreateProductDto;
use Src\Application\Interfaces\Repositories\IProductRepository;
use Src\Application\Services\ServiceResult;

class CreateProductUseCase
{
    public function __construct(
        private IProductRepository $productRepository
    ) {}

    public function createProduct(CreateProductDto $createProductDto): ServiceResult
    {
        $product = $this->productRepository->create($createProductDto);
        $images = $this->productRepository->createProductImages($product->id, $createProductDto->images);
        $product->images = $images;

        return ServiceResult::ok(
            data: $product,
            message: 'Produto criado com sucesso.'
        );
    }
}
