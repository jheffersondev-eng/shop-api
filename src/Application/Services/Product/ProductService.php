<?php

namespace Src\Application\Services\Product;

use Src\Application\Services\ServiceResult;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Src\Application\Dto\Product\CreateProductDto;
use Src\Application\Dto\Product\GetProductFilterDto;
use Src\Application\Interfaces\Repositories\IProductRepository;
use Src\Application\Interfaces\Services\IProductService;

class ProductService implements IProductService
{
    protected IProductRepository $productRepository;
    protected int $userId;
    protected int $ownerId;

    public function __construct(
        IProductRepository $productRepository,
        Auth $auth
    ) 
    {
        $this->productRepository = $productRepository;
        $user = $auth::user();
        $this->ownerId = $user->owner_id ?? $user->id;
        $this->userId = $user->id;
    }

    public function getProductsByFilter(GetProductFilterDto $getProductFilterDto): ServiceResult
    {
        try {
            $getProductFilterDto->ownerId = $this->ownerId;
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

    public function createProduct(CreateProductDto $createProductDto): ServiceResult
    {
        try {
            DB::beginTransaction();

            $createProductDto->userIdCreated = $this->userId;
            $createProductDto->ownerId = $this->ownerId;

            $product = $this->productRepository->createProduct($createProductDto);
            $images = $this->productRepository->createProductImages($product['id'], $createProductDto->images);
            $product['images'] = $images;

            DB::commit();

            return ServiceResult::ok(
                data: $product,
                message: 'Produto criado com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro ao criar produto: ' . $e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }

    private function deleteOldImage(string $image): void
    {
        if ($image && Storage::disk('shop_storage')->exists($image)) {
            Storage::disk('shop_storage')->delete($image);
        }
    }

    public function deleteProduct(int $productId): ServiceResult
    {
        try {
            DB::beginTransaction();
            $this->productRepository->deleteProduct($productId, $this->userId);
            $images = $this->productRepository->getProductImages($productId);

            foreach ($images as $image) {
                $this->productRepository->deleteProductImage($image->id);
                $this->deleteOldImage($image->image);
            }
            DB::commit();
            return ServiceResult::ok(
                data: null,
                message: 'Produto excluído com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro ao excluir produto: ' . $e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }

    public function updateProduct(int $productId, CreateProductDto $createProductDto): ServiceResult
    {
        try {
            DB::beginTransaction();

            $createProductDto->userIdUpdated = $this->userId;
            $createProductDto->ownerId = $this->ownerId;
            $product = $this->productRepository->updateProduct($productId, $createProductDto);
            
            DB::commit();

            return ServiceResult::ok(
                data: $product,
                message: 'Produto atualizado com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro ao atualizar produto: ' . $e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }
}
