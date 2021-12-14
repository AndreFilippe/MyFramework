<?php

use App\Controllers\HomeController;

$this->router->get('', HomeController::class, 'home');
$this->router->get('order/{oder_id}/package/{package_id}', HomeController::class, 'mult');
$this->router->get('order/{id}', HomeController::class, 'index');
