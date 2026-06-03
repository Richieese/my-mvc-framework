<?php

declare(strict_types=1);

namespace Core\Database;

interface Persistable
{
    public function create(array $data): int|string;
    public function update(int|string $id, array $data): int;
    public function delete(int|string $id): int;
}
