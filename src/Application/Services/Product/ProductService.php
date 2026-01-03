<?php

namespace Src\Application\Services\Product;

use Src\Application\Services\ServiceResult;
use Exception;
use Illuminate\Support\Facades\Log;
use Src\Application\Dto\Product\GetProductFilterDto;
use Src\Application\Interfaces\Repositories\IProductRepository;
use Src\Application\Interfaces\Services\IProductService;

class ProductService implements IProductService
{
    protected IProductRepository $productRepository;

    public function __construct(
        IProductRepository $productRepository
    ) 
    {
        $this->productRepository = $productRepository;
    }

    public function getProductsByFilter(GetProductFilterDto $getProductFilterDto): ServiceResult
    {
        try {
            $data = $this->productRepository->getProductsByFilter($getProductFilterDto);
            
            return ServiceResult::ok(
                data: $data,
                message: 'Produto Filtrado com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro na autenticação: ' . $e->getMessage());
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
}
