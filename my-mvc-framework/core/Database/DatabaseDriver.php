<?php

declare(strict_types=1);

namespace Core\Database;

interface DatabaseDriver
{
    public function connect(array $config): \PDO;
}
