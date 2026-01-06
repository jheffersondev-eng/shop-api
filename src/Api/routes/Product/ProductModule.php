<?php

namespace Src\Api\routes\Product;

use Illuminate\Support\Facades\Route;
use Src\Api\Controllers\Product\ProductController;
use Src\Api\routes\RouteModule;

class ProductModule
{
    public function getRoutesApi()
    {
        return new RouteModule('product', function () {
            Route::post('/create-product', [ProductController::class, 'createProduct'])->name('product.createProduct');
            Route::get('/get-products-by-filter', [ProductController::class, 'getProductsByFilter'])->name('product.getProductsByFilter');
            Route::delete('/{id}', [ProductController::class, 'deleteProduct'])->name('product.deleteProduct');
            Route::put('/{id}', [ProductController::class, 'updateProduct'])->name('product.updateProduct');
        });
    }
}