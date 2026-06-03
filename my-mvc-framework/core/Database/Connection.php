<?php

declare(strict_types=1);

namespace Core\Database;

class Connection
{
    private static ?\PDO $instance = null;

    public function __construct(private readonly DatabaseDriver $driver) {}

    public function getPdo(array $config): \PDO
    {
        if (self::$instance === null) {
            self::$instance = $this->driver->connect($config);
        }
        return self::$instance;
    }
}
