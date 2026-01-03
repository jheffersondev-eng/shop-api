<?php

use Illuminate\Support\Facades\Route;
use Src\Api\routes\Configuration;
use Src\Api\Middleware\CheckToken;

$modules = Configuration::getModules();

foreach ($modules as $module) {
    $routesApi = $module->getRoutesApi();
    if ($routesApi === null) {
        continue;
    }

    $prefix = $routesApi->getPrefix();
    $routes = $routesApi->getRoutes();
    $namespace = $routesApi->getNamespace();

    // Construir o grupo de rotas
    $routeGroup = Route::prefix($prefix);

    // Aplicar namespace se fornecido
    if (!empty($namespace)) {
        $routeGroup = $routeGroup->namespace($namespace);
    }

    // Aplicar middleware se não for auth
    if ($prefix !== 'auth') {
        $routeGroup = $routeGroup->middleware([CheckToken::class]);
    }

    $routeGroup->group($routes);
}