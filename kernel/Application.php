<?php

namespace Kernel;

use App\Exception\Handler;

class Application
{
    private $server;
    private $router;

    public function __construct()
    {
        $this->server = $_SERVER;

        $this->router = new Router();
        require_once __DIR__ . "/../app/Routes/web.php";
    }

    public function run()
    {
        try {
            $routeInfo = $this->router->getRouteInfo($this->normalizeUri($this->server['REQUEST_URI']));

            return call_user_func_array(
                [
                    new $routeInfo['controller'],
                    $routeInfo['action']
                ],
                $routeInfo['params']
            );
        } catch (\Exception $exception) {
            throw new Handler($exception);
        }
    }

    private function normalizeUri(string $url): string
    {
        $limit = substr($url, -1) === '/' ? -1 : null;
        return substr($url, 1, $limit);
    }
}
