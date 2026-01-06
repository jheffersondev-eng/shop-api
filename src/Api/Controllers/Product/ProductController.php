<?php

namespace Src\Api\Controllers\Product;

use Illuminate\Support\Facades\Auth;
use Src\Api\Controllers\BaseController;
use Src\Api\Requests\Product\CreateProductRequest;
use Src\Api\Requests\Product\ProductByFilterRequest;
use Src\Api\Requests\Product\UpdateProductRequest;
use Src\Application\Interfaces\Services\IProductService;

class ProductController extends BaseController
{
    public function __construct(
        private IProductService $productService
    ) {}

    public function getProductsByFilter(ProductByFilterRequest $request)
    {        
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->productService->getProductsByFilter($dto),
            statusCodeSuccess: 200
        );
    }

    public function createProduct(CreateProductRequest $request)
    {
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->productService->createProduct($dto),
            statusCodeSuccess: 201
        );
    }

    public function deleteProduct(int $id)
    {
        return $this->execute(
            callback: fn() => $this->productService->deleteProduct($id, Auth::id()),
            statusCodeSuccess: 200
        );
    }

    public function updateProduct(int $id, UpdateProductRequest $request)
    {
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->productService->updateProduct($id, $dto),
            statusCodeSuccess: 200
        );
    }
}