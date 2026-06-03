<?php

declare(strict_types=1);

namespace App\Models;

use Core\Database\Model;

class ProductRepository extends Model implements ProductRepositoryInterface
{
    protected string $table = 'products';

    public function allWithCategory(): array
    {
        return $this->raw('SELECT * FROM products ORDER BY name ASC');
    }

    public function totalValue(): float
    {
        $rows = $this->raw('SELECT SUM(price * stock) AS total FROM products');
        return (float) ($rows[0]['total'] ?? 0);
    }
}
