<?php

namespace Src\Api\routes\Category;

use Illuminate\Support\Facades\Route;
use Src\Api\Controllers\Category\CategoryController;
use Src\Api\routes\RouteModule;

class CategoryModule
{
    public function getRoutesApi()
    {
        return new RouteModule('category', function () {
            Route::get('/get-categories-by-filter', [CategoryController::class, 'getCategoriesByFilter'])->name('category.getCategoriesByFilter');
            Route::post('/create', [CategoryController::class, 'create'])->name('category.create');
            Route::delete('/{id}', [CategoryController::class, 'delete'])->name('category.delete');
            Route::put('/{id}', [CategoryController::class, 'update'])->name('category.update');
        });
    }
}