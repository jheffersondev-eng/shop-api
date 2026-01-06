<?php

namespace Src\Application\Services\Product;

use Src\Application\Services\ServiceResult;
use Exception;
use Illuminate\Support\Facades\Log;
use Src\Application\Dto\Product\CreateProductDto;
use Src\Application\Dto\Product\GetProductFilterDto;
use Src\Application\Exceptions\ProductNotFoundException;
use Src\Application\Exceptions\UnauthorizedException;
use Src\Application\Interfaces\Repositories\IProductRepository;
use Src\Application\Interfaces\Services\IProductService;

class ProductService implements IProductService
{
    public function __construct(
        private IProductRepository $productRepository
    ) {}

    public function getProductsByFilter(GetProductFilterDto $getProductFilterDto): ServiceResult
    {
        try {
            $data = $this->productRepository->getProductsByFilter($getProductFilterDto);
            
            return ServiceResult::ok(
                data: $data,
                message: 'Produto Filtrado com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro ao filtrar produtos: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getProductImages(int $productId): ServiceResult
    {
        try {
            $images = $this->productRepository->getProductImages($productId);

            return ServiceResult::ok(
                data: $images,
                message: 'Imagens do produto obtidas com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro ao obter imagens do produto: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createProduct(CreateProductDto $createProductDto): ServiceResult
    {
        try {
            $product = $this->productRepository->createProduct($createProductDto);
            $images = $this->productRepository->createProductImages($product->id, $createProductDto->images);
            $product->images = $images;

            return ServiceResult::ok(
                data: $product,
                message: 'Produto criado com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro ao criar produto: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteProduct(int $productId, int $userIdDeleted): ServiceResult
    {
        try {
            $this->productRepository->deleteProduct($productId, $userIdDeleted);
            $images = $this->productRepository->getProductImages($productId);

            foreach ($images as $image) {
                $this->productRepository->deleteProductImage($image->id);
            }
            
            return ServiceResult::ok(
                data: null,
                message: 'Produto excluído com sucesso.'
            );
        } catch (ProductNotFoundException $e) {
            Log::error('Produto não encontrado: ' . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error('Erro ao excluir produto: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateProduct(int $productId, CreateProductDto $createProductDto): ServiceResult
    {
        try {
            $product = $this->productRepository->updateProduct($productId, $createProductDto);

            return ServiceResult::ok(
                data: $product,
                message: 'Produto atualizado com sucesso.'
            );
        } catch (ProductNotFoundException $e) {
            Log::error('Produto não encontrado: ' . $e->getMessage());
            throw $e;
        } catch (UnauthorizedException $e) {
            Log::warning('Tentativa de acesso não autorizado: ' . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error('Erro ao atualizar produto: ' . $e->getMessage());
            throw $e;
        }
    }
}
