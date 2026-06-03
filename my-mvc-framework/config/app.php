<?php

declare(strict_types=1);

use App\Models\ProductRepositoryInterface;
use App\Models\ProductRepository;

return [
    'bindings' => [
        ProductRepositoryInterface::class => ProductRepository::class,
    ],
];
