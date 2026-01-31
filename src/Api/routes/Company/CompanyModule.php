<?php

namespace Src\Api\routes\Company;

use Illuminate\Support\Facades\Route;
use Src\Api\Controllers\Company\CompanyController;
use Src\Api\routes\RouteModule;

class CompanyModule
{
    public function getRoutesApi()
    {
        return new RouteModule('company', function () {
            Route::get('/get-companies-by-filter', [CompanyController::class, 'getCompaniesByFilter'])->name('company.getCompaniesByFilter');
            Route::post('/create', [CompanyController::class, 'create'])->name('company.create');
            Route::delete('/{id}', [CompanyController::class, 'delete'])->name('company.delete');
            Route::put('/{id}', [CompanyController::class, 'update'])->name('company.update');
        });
    }
}