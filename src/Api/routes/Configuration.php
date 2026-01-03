<?php

namespace Src\Api\routes;

use Src\Api\routes\Auth\AuthModule;
use Src\Api\routes\Product\ProductModule;

class Configuration
{
    public static function getModules(): array
    {
        return [
            new AuthModule(),
            new ProductModule(),
        ];
    }
}