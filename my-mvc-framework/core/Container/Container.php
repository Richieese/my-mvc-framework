<?php

declare(strict_types=1);

namespace Core\Container;

class Container
{
    private array $bindings   = [];
    private array $singletons = [];

    public function bind(string $abstract, callable|string $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function singleton(string $abstract, callable|string $concrete): void
    {
        $this->bindings[$abstract] = function () use ($abstract, $concrete): object {
            if (!isset($this->singletons[$abstract])) {
                $this->singletons[$abstract] = is_callable($concrete)
                    ? $concrete($this)
                    : $this->build($concrete);
            }
            return $this->singletons[$abstract];
        };
    }

    public function make(string $abstract): object
    {
        if ($abstract === self::class || $abstract === Container::class) {
            return $this;
        }

        if (isset($this->bindings[$abstract])) {
            $concrete = $this->bindings[$abstract];
            return is_callable($concrete) ? $concrete($this) : $this->build($concrete);
        }

        return $this->build($abstract);
    }

    private function build(string $class): object
    {
        $reflector   = new \ReflectionClass($class);
        $constructor = $reflector->getConstructor();

        if ($constructor === null) {
            return new $class();
        }

        $params = array_map(function (\ReflectionParameter $param): mixed {
            $type = $param->getType();
            if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                return $this->make($type->getName());
            }
            if ($param->isDefaultValueAvailable()) {
                return $param->getDefaultValue();
            }
            throw new \RuntimeException(
                "Cannot resolve [{$param->getName()}] in [{$param->getDeclaringClass()?->getName()}]."
            );
        }, $constructor->getParameters());

        return $reflector->newInstanceArgs($params);
    }
}
