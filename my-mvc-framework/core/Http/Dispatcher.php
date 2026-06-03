<?php

declare(strict_types=1);

namespace Core\Http;

use App\Middleware\MiddlewareInterface;
use Core\Container\Container;

class Dispatcher
{
    /** @var MiddlewareInterface[] */
    private array $middleware = [];

    public function __construct(private readonly Container $container) {}

    public function addMiddleware(MiddlewareInterface $middleware): void
    {
        $this->middleware[] = $middleware;
    }

    public function dispatch(array $resolved): Response
    {
        $core = function (Request $request) use ($resolved): Response {
            [$controllerClass, $method] = $resolved['action'];
            $params     = $resolved['params'];
            $controller = $this->container->make($controllerClass);

            if (!method_exists($controller, $method)) {
                throw new \RuntimeException("Method {$method} not found on {$controllerClass}");
            }

            $response = $controller->$method(...array_values($params));

            if (!$response instanceof Response) {
                throw new \RuntimeException('Controller actions must return a Response instance.');
            }

            return $response;
        };

        $pipeline = array_reduce(
            array_reverse($this->middleware),
            fn(callable $carry, MiddlewareInterface $mw) =>
                fn(Request $req) => $mw->handle($req, $carry),
            $core
        );

        return $pipeline(new Request());
    }
}
