<?php

namespace Src\Api\routes\Profile;

use Illuminate\Support\Facades\Route;
use Src\Api\Controllers\Profile\ProfileController;
use Src\Api\routes\RouteModule;

class ProfileModule
{
    public function getRoutesApi()
    {
        return new RouteModule('profile', function () {
            Route::get('/get-profiles-by-filter', [ProfileController::class, 'getProfilesByFilter'])->name('profile.getProfilesByFilter');
            Route::post('/create', [ProfileController::class, 'create'])->name('profile.create');
            Route::delete('/{id}', [ProfileController::class, 'delete'])->name('profile.delete');
            Route::put('/{id}', [ProfileController::class, 'update'])->name('profile.update');
        });
    }
}