<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\ProductController;

$router->get('/', [HomeController::class, 'index']);

$router->get('/products/create', [ProductController::class, 'create']);
$router->post('/products', [ProductController::class, 'store']);
$router->get('/products/{id}/edit', [ProductController::class, 'edit']);
$router->post('/products/{id}/update', [ProductController::class, 'update']);
$router->post('/products/{id}/delete', [ProductController::class, 'destroy']);

$router->get('/products/{id}', [ProductController::class, 'show']);