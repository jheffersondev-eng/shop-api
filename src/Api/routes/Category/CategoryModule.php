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
            Route::post('/create', [CategoryController::class, 'createCategory'])->name('category.createCategory');
            Route::get('/get-categories-by-filter', [CategoryController::class, 'getCategoriesByFilter'])->name('category.getCategoriesByFilter');
            Route::delete('/{id}', [CategoryController::class, 'deleteCategory'])->name('category.deleteCategory');
            Route::put('/{id}', [CategoryController::class, 'updateCategory'])->name('category.updateCategory');
        });
    }
}