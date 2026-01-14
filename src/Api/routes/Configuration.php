<?php

namespace Src\Api\routes;

use Src\Api\routes\Auth\AuthModule;
use Src\Api\routes\Category\CategoryModule;
use Src\Api\routes\Product\ProductModule;
use Src\Api\routes\Profile\ProfileModule;
use Src\Api\routes\Unit\UnitModule;
use Src\Api\routes\User\UserModule;

class Configuration
{
    public static function getModules(): array
    {
        return [
            new AuthModule(),
            new ProductModule(),
            new UnitModule(),
            new CategoryModule(),
            new UserModule(),
            new ProfileModule(),
        ];
    }
}