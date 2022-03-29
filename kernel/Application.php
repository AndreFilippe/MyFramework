<?php

namespace Kernel;

use App\Exception\Handler;
use Kernel\Interfaces\RouterInterface;

class Application
{
    public function __construct(private RouterInterface $router, private Request $request)
    {
        $this->configRouter();
    }

    public function run()
    {
        try {
            $route = $this->router->getRoute($this->request);
            $route->run($this->request);
        } catch (\Exception $exception) {
            throw new Handler($exception);
        }
    }

    private function configRouter()
    {
        require_once __DIR__ . "/../app/Routes/web.php";
    }
}
