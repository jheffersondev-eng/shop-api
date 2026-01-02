<?php

namespace Src\Infrastructure\Providers;

use Src\Application\Interfaces\Repositories\IUserRepository;
use Src\Infrastructure\Persistence\Repositories\UserRepository;
use Src\Application\Services\Auth\AuthService;
use Src\Application\Interfaces\Services\IAuthService;
use Illuminate\Contracts\Foundation\Application;

class AppDependencyInjection
{
    public static function register(Application $app)
    {
        //register bindings repositorys
        $app->bind(IUserRepository::class, UserRepository::class);

        //register bindings services
        $app->bind(IAuthService::class, AuthService::class);
    }
}
