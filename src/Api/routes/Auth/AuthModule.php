<?php

namespace Src\Api\routes\Auth;

use Illuminate\Support\Facades\Route;
use Src\Api\Controllers\Auth\AuthController;
use Src\Api\Controllers\User\UserController;
use Src\Api\routes\RouteModule;

class AuthModule
{
    public function getRoutesApi()
    {
        return new RouteModule('', function () {
            Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
            Route::post('user/register', [UserController::class, 'register'])->name('user.register');
            Route::post('user/verify', [UserController::class, 'verify'])->name('user.verify');
            Route::post('user/resend-verify-email', [UserController::class, 'resendVerifyEmail'])->name('user.resendVerifyEmail');
        });
    }
}