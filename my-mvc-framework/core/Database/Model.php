<?php

declare(strict_types=1);

namespace Core\Database;

abstract class Model implements Findable, Persistable
{
    protected string $table      = '';
    protected string $primaryKey = 'id';

    public function __construct(protected readonly \PDO $pdo) {}

    public function all(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find(int|string $id): array|false
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ? LIMIT 1"
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function where(string $column, mixed $value): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM {$this->table} WHERE {$column} = ?"
        );
        $stmt->execute([$value]);
        return $stmt->fetchAll();
    }

    public function first(string $column, mixed $value): array|false
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM {$this->table} WHERE {$column} = ? LIMIT 1"
        );
        $stmt->execute([$value]);
        return $stmt->fetch();
    }

    public function count(): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM {$this->table}");
        $stmt->execute();
        return (int) $stmt->fetch()['total'];
    }

    public function create(array $data): int|string
    {
        $columns      = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $stmt         = $this->pdo->prepare(
            "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})"
        );
        $stmt->execute(array_values($data));
        return $this->pdo->lastInsertId();
    }

    public function update(int|string $id, array $data): int
    {
        $sets = implode(', ', array_map(fn($col) => "{$col} = ?", array_keys($data)));
        $stmt = $this->pdo->prepare(
            "UPDATE {$this->table} SET {$sets} WHERE {$this->primaryKey} = ?"
        );
        $stmt->execute([...array_values($data), $id]);
        return $stmt->rowCount();
    }

    public function delete(int|string $id): int
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?"
        );
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
    
    public function raw(string $sql, array $bindings = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bindings);
        return $stmt->fetchAll();
    }
}
