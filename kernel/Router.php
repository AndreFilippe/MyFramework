<?php

namespace Kernel;

use Kernel\Exceptions\RouteNotFoundException;
use Kernel\Interfaces\RouterInterface;

class Router implements RouterInterface
{
    private array $routes = [];

    public function request(string $method, string $uri, string $controller, string $action): void
    {
        $this->routes[$method][$uri] = new Route($uri, $controller, $action);
    }

    public function get(string $uri, string $controller, string $action): void
    {
        $this->request('GET', $uri, $controller, $action);
    }

    public function post(string $uri, string $controller, string $action): void
    {
        $this->request('POST', $uri, $controller, $action);
    }

    public function put(string $uri, string $controller, string $action): void
    {
        $this->request('PUT', $uri, $controller, $action);
    }

    public function patch(string $uri, string $controller, string $action): void
    {
        $this->request('PATCH', $uri, $controller, $action);
    }

    public function delete(string $uri, string $controller, string $action): void
    {
        $this->request('DELETE', $uri, $controller, $action);
    }

    public function getRoute(Request $request): Route
    {
        $routeByMethod = $this->routes[$request->method] ?? throw new RouteNotFoundException();

        $routes = array_filter($routeByMethod, fn ($route) => $route->isMatch($request->uri));

        return !empty($routes) ? reset($routes) : throw new RouteNotFoundException();
    }
}
