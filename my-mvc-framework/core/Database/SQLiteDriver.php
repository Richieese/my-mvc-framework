<?php

declare(strict_types=1);

namespace Core\Database;

class SQLiteDriver implements DatabaseDriver
{
    public function connect(array $config): \PDO
    {
        $path = $config['database'] ?? BASE_PATH . '/database.sqlite';
        return new \PDO("sqlite:{$path}", options: [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ]);
    }
}
