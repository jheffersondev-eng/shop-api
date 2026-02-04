<?php

namespace Src\Application\UseCase\Product;

use Src\Application\Dto\Product\CreateProductDto;
use Src\Application\Interfaces\Repositories\IProductRepository;
use Src\Application\Services\ServiceResult;

class UpdateProductUseCase
{
    public function __construct(
        private IProductRepository $productRepository
    ) {}

    public function updateProduct(int $productId, CreateProductDto $createProductDto): ServiceResult
    {
        $product = $this->productRepository->update($productId, $createProductDto);

        if(!empty($createProductDto->images)) {
            $images = $this->productRepository->updateProductImages($productId, $createProductDto->ownerId, $createProductDto->images);
            $product->images = $images;
        }

        return ServiceResult::ok(
            data: $product,
            message: 'Produto atualizado com sucesso.'
        );
    }
}
