<?php

namespace Src\Api\Controllers\Product;

use Src\Application\Interfaces\Services\IAuthService;
use Src\Api\Controllers\BaseController;
use Src\Api\Requests\Product\ProductByFilterRequest;

class ProductController extends BaseController
{
    public function __construct(
        private IAuthService $authService
    ) {}

    public function getProductByFilter(ProductByFilterRequest $productByFilterRequest)
    {        
        $dto = $productByFilterRequest->getDto();

        return $this->execute(
            callback: fn() => $this->authService->authenticate($dto),
            statusCodeSuccess: 200
        );
    }
}
