<?php

namespace Kernel\Interfaces;

use Kernel\Request;
use Kernel\Route;

interface RouterInterface
{
    public function request(string $method, string $uri, string $controller, string $action): void;
    public function get(string $uri, string $controller, string $action): void;
    public function post(string $uri, string $controller, string $action): void;
    public function put(string $uri, string $controller, string $action): void;
    public function patch(string $uri, string $controller, string $action): void;
    public function delete(string $uri, string $controller, string $action): void;
    public function getRoute(Request $request): Route;
}
