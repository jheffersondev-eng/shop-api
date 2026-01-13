<?php

namespace Src\Api\routes\Unit;

use Illuminate\Support\Facades\Route;
use Src\Api\Controllers\Unit\UnitController;
use Src\Api\routes\RouteModule;

class UnitModule
{
    public function getRoutesApi()
    {
        return new RouteModule('unit', function () {
            Route::get('/get-units-by-filter', [UnitController::class, 'getUnitsByFilter'])->name('unit.getUnitsByFilter');
            Route::post('/create', [UnitController::class, 'create'])->name('unit.create');
            Route::put('/{id}', [UnitController::class, 'update'])->name('unit.update');
            Route::delete('/{id}', [UnitController::class, 'delete'])->name('unit.delete');
        });
    }
}