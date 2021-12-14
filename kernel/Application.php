<?php

namespace Kernel;

use App\Exception\Handler;
use Kernel\Interfaces\RouterInterface;

class Application
{
    public function __construct(private RouterInterface $router, private string $requestUri)
    {
        $this->configRouter();
    }

    public function run()
    {
        try {
            $routeInfo = $this->router->getRouteInfo($this->normalizeUri($this->requestUri));

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

    private function configRouter()
    {
        require_once __DIR__ . "/../app/Routes/web.php";
    }

    private function normalizeUri(string $url): string
    {
        $limit = substr($url, -1) === '/' ? -1 : null;
        return substr($url, 1, $limit);
    }
}
