<?php

namespace Src\Api\routes\Company;

use Illuminate\Support\Facades\Route;
use Src\Api\Controllers\Company\CompanyController;
use Src\Api\routes\RouteModule;

class CompanyPublicModule
{
    public function getRoutesApi()
    {
        return new RouteModule('auth', function () {
            Route::get('company/get-all-companies-by-filter', [CompanyController::class, 'getAllCompaniesByFilter'])->name('company.getCompaniesByFilter');
        });
    }
}