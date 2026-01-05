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
            Route::post('/create', [UnitController::class, 'createUnit'])->name('unit.createUnit');
            Route::put('/{id}', [UnitController::class, 'updateUnit'])->name('unit.updateUnit');
            Route::delete('/{id}', [UnitController::class, 'deleteUnit'])->name('unit.deleteUnit');
        });
    }
}