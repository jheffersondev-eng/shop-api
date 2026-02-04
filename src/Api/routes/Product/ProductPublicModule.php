<?php

namespace Src\Api\routes\Product;

use Illuminate\Support\Facades\Route;
use Src\Api\Controllers\Product\ProductController;
use Src\Api\routes\RouteModule;

class ProductPublicModule
{
    public function getRoutesApi()
    {
        return new RouteModule('auth', function () {
            Route::get('/product/get-all-products-by-filter', [ProductController::class, 'getAllProductsByFilter'])->name('product.getAllProductsByFilter');
        });
    }
}