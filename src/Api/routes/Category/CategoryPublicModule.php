<?php

namespace Src\Api\routes\Category;

use Illuminate\Support\Facades\Route;
use Src\Api\Controllers\Category\CategoryController;
use Src\Api\routes\RouteModule;

class CategoryPublicModule
{
    public function getRoutesApi()
    {
        return new RouteModule('auth', function () {
            Route::get('/category/get-all-categories-by-filter', [CategoryController::class, 'getAllCategoriesByFilter'])->name('category.getAllCategoriesByFilter');
        });
    }
}