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

    public function create(CreateProductRequest $request)
    {
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->productService->create($dto),
            statusCodeSuccess: 201
        );
    }

    public function delete(int $id)
    {
        return $this->execute(
            callback: fn() => $this->productService->delete($id, Auth::id()),
            statusCodeSuccess: 200
        );
    }

    public function update(int $id, UpdateProductRequest $request)
    {
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->productService->update($id, $dto),
            statusCodeSuccess: 200
        );
    }
}