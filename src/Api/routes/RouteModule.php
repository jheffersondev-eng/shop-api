<?php

namespace Src\Api\routes;

class RouteModule
{
    private string $prefix;
    private \Closure $routes;
    private string $namespace;

    /**
     * Route constructor.
     * @param String $prefix
     * @param \Closure $routes
     * @param string $namespace
     */
    public function __construct(string $prefix, \Closure $routes, string $namespace = "")
    {
        $this->prefix = $prefix;
        $this->routes = $routes;
        $this->namespace = $namespace;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }

    public function getRoutes(): \Closure
    {
        return $this->routes;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }
}
