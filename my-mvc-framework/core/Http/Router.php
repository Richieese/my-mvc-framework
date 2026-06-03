<?php

declare(strict_types=1);

namespace Core\Http;

class Router
{
    private array $routes = [];

    public function get(string $uri, array $action): void
    {
        $this->register('GET', $uri, $action);
    }

    public function post(string $uri, array $action): void
    {
        $this->register('POST', $uri, $action);
    }

    public function register(string $method, string $uri, array $action): void
    {
        $pattern        = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $uri);
        $this->routes[] = [
            'method'  => strtoupper($method),
            'pattern' => '#^' . $pattern . '$#',
            'action'  => $action,
        ];
    }

    public function resolve(Request $request): array
    {
        foreach ($this->routes as $route) {
            if ($route['method'] !== $request->method) {
                continue;
            }
            if (preg_match($route['pattern'], $request->uri, $matches)) {
                $params = array_filter($matches, fn($k) => !is_int($k), ARRAY_FILTER_USE_KEY);
                return ['action' => $route['action'], 'params' => $params];
            }
        }
        throw new \RuntimeException("No route matched: {$request->method} {$request->uri}", 404);
    }
}
