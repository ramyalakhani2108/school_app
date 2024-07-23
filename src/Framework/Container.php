<?php

declare(strict_types=1);

namespace Framework;

use ContainerException;
use ReflectionClass;
use ReflectionNamedType;

class Container
{

    private array $definitions = [];
    private array $resolved = [];

    public function add_definitions(array $new_definitions)
    {
        $this->definitions = [...$this->definitions, ...$new_definitions];
    }

    public function resolve(string $class_name)
    {
        $reflection_class = new ReflectionClass($class_name);

        if (!$reflection_class->isInstantiable()) {
            throw new ContainerException("Class {$class_name} is not instantiable ");
        }

        $constructor = $reflection_class->getConstructor();
        if (!$constructor) {
            return new $class_name;
        }

        $params = $constructor->getParameters();
        if (count($params) === 0) {
            return new $class_name;
        }
        $dependencies = [];

        foreach ($params as $param) {
            $name = $param->getName();
            $type = $param->getType();

            if (!$type) {
                throw new ContainerException("Failed to resolve class {$class_name} because param {$name} is missing a typehint.");
            }
            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                throw new ContainerException("Failed to resolve {$class_name} because invalid param name.");
            }
            $dependencies[] = $this->get($type->getName());
        }
        return $reflection_class->newInstanceArgs($dependencies);
    }

    public function get(string $id)
    {
        if (!array_key_exists($id, $this->definitions)) {
            throw new ContainerException("Class {$id} doesn't exist in the container.");
        }
        $factory = $this->definitions[$id];
        if (array_key_exists($id, $this->resolved)) {
            return $this->resolved[$id];
        }
        $dependency = $factory($this);
        $this->resolved[$id] = $dependency;

        return $dependency;
    }
}
