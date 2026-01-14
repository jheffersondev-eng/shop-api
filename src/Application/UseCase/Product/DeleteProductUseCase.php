<?php

namespace Src\Application\UseCase\Product;

use Src\Application\Interfaces\Repositories\IProductRepository;
use Src\Application\Services\ServiceResult;

class DeleteProductUseCase
{
    public function __construct(
        private IProductRepository $productRepository
    ) {}

    public function deleteProduct(int $productId, int $userIdDeleted): ServiceResult
    {
        $this->productRepository->delete($productId, $userIdDeleted);
        $images = $this->productRepository->getProductImages($productId);

        foreach ($images as $image) {
            $this->productRepository->deleteProductImage($image->id);
        }

        return ServiceResult::ok(
            data: null,
            message: 'Produto excluído com sucesso.'
        );
    }
}
