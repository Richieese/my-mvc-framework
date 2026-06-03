<?php

declare(strict_types=1);

namespace Core\Http;

class Request
{
    public readonly string $method;
    public readonly string $uri;

    public function __construct()
    {
        $this->method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $rawUri       = $_SERVER['REQUEST_URI'] ?? '/';
        $path         = parse_url($rawUri, PHP_URL_PATH) ?: '/';

        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        if ($scriptDir !== '/' && str_starts_with($path, $scriptDir)) {
            $path = substr($path, strlen($scriptDir));
        }

        $this->uri = '/' . ltrim($path, '/');
    }

    public function post(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $default;
    }

    public function all(): array
    {
        return $_POST;
    }
}
