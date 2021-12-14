<?php

namespace Kernel;

use Kernel\Enums\Regex;
use Kernel\Interfaces\RouterInterface;

class Router implements RouterInterface
{
    private array $routes;

    public function get(string $uri, string $controller, string $method): void
    {
        $this->routes[$uri] = [
            'method' => 'GET',
            'regex' => $this->generateRegexUri($uri),
            'controller' => $controller,
            'action' => $method
        ];
    }

    public function getRouteInfo(string $uri): array
    {
        if (empty($uri)) return $this->normalizeRouteInfo($uri, $uri);

        foreach ($this->routes as $key => $route) {
            $regex = $route['regex'];
            if (is_null($regex)) continue;

            if (preg_match($regex, $uri)) return $this->normalizeRouteInfo($key, $uri);
        }

        throw new \Exception("Route not found", 404);
    }

    private function generateRegexUri(string $uri): ?string
    {
        if (empty($uri)) return null;

        $backslashAdjusted = preg_replace(Regex::BACKSLASH, Regex::BACKSLASH_IN_REGEX, $uri);
        $paramsAdjusted = preg_replace(Regex::FORMAT_PARAM, "+" . Regex::LETTERS_NUMBERS . "+", $backslashAdjusted);


        $limit = substr($paramsAdjusted, -1) === '+' ? -1 : null;
        return "/" . substr($paramsAdjusted, 1, $limit) . "/";
    }

    private function normalizeRouteInfo($uri, $inputUri): array
    {
        return [...$this->routes[$uri], 'params' => $this->getParams($uri, $inputUri)];
    }

    private function getParams($uri, $inputUri)
    {
        $splitInputUri = explode('/', $inputUri);
        $params = $this->getParamPositions($uri);

        foreach ($params as $key => $param) {
            $paramValues[$param] = $splitInputUri[$key];
        }

        return $paramValues ?? [];
    }

    private function getParamPositions($uri): array
    {
        $splitUri = explode('/', $uri);

        $paramPositions = preg_grep(Regex::FORMAT_PARAM, $splitUri);

        return array_map(
            fn ($postion) => $this->removeParamLimit($postion),
            $paramPositions
        );
    }

    private function removeParamLimit(string $params): string
    {
        return str_replace([Regex::PARAM_START, Regex::PARAM_END], '', $params);
    }
}
