<?php

use Kernel\Application;
use Kernel\Request;
use Kernel\Router;

require __DIR__ . '/../config/bootstrap.php';

$router = new Router();
$request = (new Request())->build();

(new Application($router, $request))->run();
