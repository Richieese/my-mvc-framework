<?php

declare(strict_types=1);

namespace App;

enum Category: string
{
    case Electronics    = 'Electronics';
    case Furniture      = 'Furniture';
    case OfficeSupplies = 'Office Supplies';
    case drinks         = 'Drinks';

    public static function labels(): array
    {
        return array_map(fn(self $c) => $c->value, self::cases());
    }
}
