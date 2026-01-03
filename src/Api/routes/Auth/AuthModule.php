<?php

namespace Src\Api\routes\Auth;

use Illuminate\Support\Facades\Route;
use Src\Api\Controllers\Auth\AuthController;
use Src\Api\routes\RouteModule;

class AuthModule
{
    public function getRoutesApi()
    {
        return new RouteModule('auth', function () {
            Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
        });
    }
}