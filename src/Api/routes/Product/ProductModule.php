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
            Route::get('/get-products-by-filter', [ProductController::class, 'getProductsByFilter'])->name('product.getProductsByFilter');
            Route::post('/create', [ProductController::class, 'create'])->name('product.create');
            Route::delete('/{id}', [ProductController::class, 'delete'])->name('product.delete');
            Route::put('/{id}', [ProductController::class, 'update'])->name('product.update');
        });
    }
}