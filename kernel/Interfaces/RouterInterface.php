<?php

namespace Kernel\Interfaces;

interface RouterInterface
{
    public function get(string $uri, string $controller, string $method): void;
    public function getRouteInfo(string $uri): array;
}
