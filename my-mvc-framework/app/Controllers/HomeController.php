<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\ProductRepositoryInterface;
use Core\Http\Response;
use Core\View\Engine;

class HomeController extends BaseController
{
    public function __construct(
        Engine $view,
        private readonly ProductRepositoryInterface $products,
    ) {
        parent::__construct($view);
    }

    public function index(): Response
    {
        $totalProducts = $this->products->count();
        $totalValue    = $this->products->totalValue();
        $allProducts   = $this->products->allWithCategory();

        return $this->render('dashboard', compact(
            'totalProducts',
            'totalValue',
            'allProducts'
        ));
    }
}
