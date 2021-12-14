<?php

use Kernel\Application;
use Kernel\Router;

require __DIR__ . '/../config/bootstrap.php';

$router = new Router();
(new Application($router, $_SERVER['REQUEST_URI']))->run();
