<?php

declare(strict_types=1);

namespace App\Models;

use Core\Database\Findable;
use Core\Database\Persistable;

interface ProductRepositoryInterface extends Findable, Persistable
{
    public function allWithCategory(): array;
    public function totalValue(): float;
}
