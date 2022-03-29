<?php

use App\Controllers\HomeController;

$this->router->get('', HomeController::class, 'home');
$this->router->get('/', HomeController::class, 'home');
$this->router->get('foo', HomeController::class, 'home');
$this->router->get('foo/{id}', HomeController::class, 'index');
$this->router->get('foo/{id}/bar/{bar_id}', HomeController::class, 'mult');
