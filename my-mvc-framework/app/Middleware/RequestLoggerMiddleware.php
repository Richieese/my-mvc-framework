<?php

declare(strict_types=1);

namespace App\Middleware;

use Core\Http\Request;
use Core\Http\Response;

class RequestLoggerMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly string $logPath) {}

    public function handle(Request $request, callable $next): Response
    {
        $this->writeLog($request);
        return $next($request);
    }

    private function writeLog(Request $request): void
    {
        $dir = dirname($this->logPath);

        if (!is_dir($dir)) {
            mkdir($dir, 0755, recursive: true);
        }

        $timestamp = date('Y-m-d H:i:s');
        $line      = "[{$timestamp}] {$request->method} {$request->uri}" . PHP_EOL;

        file_put_contents($this->logPath, $line, FILE_APPEND | LOCK_EX);
    }
}
