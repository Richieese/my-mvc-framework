<?php

declare(strict_types=1);

namespace Core\Database;

class QueryBuilder
{
    private string $table    = '';
    private array  $wheres   = [];
    private array  $bindings = [];
    private string $orderBy  = '';

    public function __construct(private readonly \PDO $pdo) {}

    public function table(string $table): static
    {
        $clone        = clone $this;
        $clone->table = $table;
        return $clone;
    }

    public function where(string $column, mixed $value): static
    {
        $clone             = clone $this;
        $clone->wheres[]   = "{$column} = ?";
        $clone->bindings[] = $value;
        return $clone;
    }

    public function orderBy(string $column, string $direction = 'ASC'): static
    {
        $clone          = clone $this;
        $clone->orderBy = " ORDER BY {$column} {$direction}";
        return $clone;
    }

    public function findAll(): array
    {
        $sql  = "SELECT * FROM {$this->table}";
        $sql .= $this->buildWhere();
        $sql .= $this->orderBy;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);
        return $stmt->fetchAll();
    }

    public function findOne(): array|false
    {
        $sql  = "SELECT * FROM {$this->table}";
        $sql .= $this->buildWhere();
        $sql .= ' LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);
        return $stmt->fetch();
    }

    public function insert(array $data): int|string
    {
        $columns      = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $stmt         = $this->pdo->prepare(
            "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})"
        );
        $stmt->execute(array_values($data));
        return $this->pdo->lastInsertId();
    }

    public function update(array $data): int
    {
        $sets = implode(', ', array_map(fn($col) => "{$col} = ?", array_keys($data)));
        $sql  = "UPDATE {$this->table} SET {$sets}";
        $sql .= $this->buildWhere();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([...array_values($data), ...$this->bindings]);
        return $stmt->rowCount();
    }

    public function delete(): int
    {
        $sql  = "DELETE FROM {$this->table}";
        $sql .= $this->buildWhere();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);
        return $stmt->rowCount();
    }

    private function buildWhere(): string
    {
        if (empty($this->wheres)) {
            return '';
        }
        return ' WHERE ' . implode(' AND ', $this->wheres);
    }
}
