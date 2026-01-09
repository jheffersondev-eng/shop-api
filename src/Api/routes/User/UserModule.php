<?php

namespace Src\Api\routes\User;

use Illuminate\Support\Facades\Route;
use Src\Api\Controllers\User\UserController;
use Src\Api\routes\RouteModule;

class UserModule
{
    public function getRoutesApi()
    {
        return new RouteModule('user', function () {
            Route::get('/get-users-by-filter', [UserController::class, 'getUsersByFilter'])->name('user.getUsersByFilter');
            Route::post('/create', [UserController::class, 'create'])->name('user.create');
            Route::put('/{id}', [UserController::class, 'update'])->name('user.update');
            Route::delete('/{id}', [UserController::class, 'delete'])->name('user.delete');
        });
    }
}
