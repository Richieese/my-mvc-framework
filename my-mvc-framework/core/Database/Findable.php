<?php

declare(strict_types=1);

namespace Core\Database;

interface Findable
{
    public function all(): array;
    public function find(int|string $id): array|false;
    public function where(string $column, mixed $value): array;
    public function first(string $column, mixed $value): array|false;
    public function count(): int;
}
