<?php

namespace Src\Infrastructure\Providers;

use Src\Application\Interfaces\Repositories\IUserRepository;
use Src\Infrastructure\Persistence\Repositories\UserRepository;
use Src\Application\Services\Auth\AuthService;
use Src\Application\Interfaces\Services\IAuthService;
use Illuminate\Contracts\Foundation\Application;
use Src\Application\Interfaces\Repositories\IProductRepository;
use Src\Application\Interfaces\Repositories\IUnitRepository;
use Src\Application\Interfaces\Services\IProductService;
use Src\Application\Interfaces\Services\IUnitService;
use Src\Application\Services\Product\ProductService;
use Src\Application\Services\Unit\UnitService;
use Src\Infrastructure\Persistence\Repositories\ProductRepository;
use Src\Infrastructure\Persistence\Repositories\UnitRepository;

class AppDependencyInjection
{
    public static function register(Application $app)
    {
        //register bindings services
        $app->bind(IAuthService::class, AuthService::class);
        $app->bind(IProductService::class, ProductService::class);
        $app->bind(IUnitService::class, UnitService::class);
        
        //register bindings repositorys
        $app->bind(IUserRepository::class, UserRepository::class);
        $app->bind(IProductRepository::class, ProductRepository::class);
        $app->bind(IUnitRepository::class, UnitRepository::class);
    }
}
