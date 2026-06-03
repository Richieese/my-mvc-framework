<?php

declare(strict_types=1);

namespace Core;

use App\Middleware\RequestLoggerMiddleware;
use Core\Container\Container;
use Core\Database\Connection;
use Core\Database\DatabaseDriver;
use Core\Database\MySQLDriver;
use Core\Http\Dispatcher;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\Router;
use Core\View\Engine;

class Application
{
    private readonly Container $container;
    private readonly Router    $router;

    public function __construct(private readonly string $basePath)
    {
        $this->container = new Container();
        $this->router    = new Router();
        $this->registerCoreBindings();
    }

    private function registerCoreBindings(): void
    {
        $basePath  = $this->basePath;
        $container = $this->container;

        $container->singleton(Engine::class, fn() => new Engine($basePath . '/app/Views'));

        $dbConfig = require $basePath . '/config/database.php';

        $container->bind(DatabaseDriver::class, MySQLDriver::class);

        $container->singleton(\PDO::class, function (Container $c) use ($dbConfig): \PDO {
            $connection = new Connection($c->make(DatabaseDriver::class));
            return $connection->getPdo($dbConfig);
        });

        $container->singleton(Router::class, fn() => $this->router);
        $container->bind(Dispatcher::class, Dispatcher::class);

        $this->registerRoutes($basePath . '/routes/web.php');

        $appConfig = require $basePath . '/config/app.php';
        foreach ($appConfig['bindings'] as $abstract => $concrete) {
            $container->bind($abstract, $concrete);
        }
    }

    private function registerRoutes(string $routeFile): void
    {
        $router = $this->router;
        require $routeFile;
    }

    public function run(): void
    {
        $request    = new Request();
        $dispatcher = $this->container->make(Dispatcher::class);

        $dispatcher->addMiddleware(
            new RequestLoggerMiddleware($this->basePath . '/storage/logs/requests.log')
        );

        try {
            $resolved = $this->router->resolve($request);
            $response = $dispatcher->dispatch($resolved);
        } catch (\RuntimeException $e) {
            $code     = (int) $e->getCode();
            $code     = $code > 0 ? $code : 500;
            $response = (new Response())
                ->setStatusCode($code)
                ->setBody("<h1>Error {$code}</h1><p>" . htmlspecialchars($e->getMessage()) . '</p>');
        }

        $response->send();
    }
}
