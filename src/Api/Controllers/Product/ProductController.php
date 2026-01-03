<?php

namespace Src\Api\Controllers\Product;

use Src\Api\Controllers\BaseController;
use Src\Api\Requests\Product\CreateProductRequest;
use Src\Api\Requests\Product\ProductByFilterRequest;
use Src\Application\Interfaces\Services\IProductService;

class ProductController extends BaseController
{
    public function __construct(
        private IProductService $productService
    ) {}

    public function getProductsByFilter(ProductByFilterRequest $request)
    {        
        $dto = $request->getDto();
        $result = $this->productService->getProductsByFilter($dto);

        return response()->json([
            'success' => $result->success,
            'data' => $result->data,
            'message' => $result->message
        ], 200);
    }

    public function createProduct(CreateProductRequest $request)
    {
        $dto = $request->getDto();
        $result = $this->productService->getProductsByFilter($dto);

        return response()->json([
            'success' => $result->success,
            'data' => $result->data,
            'message' => $result->message
        ], 200);
    }
}
