<?php

namespace Indexer\Representation;

class ClassRepresentation
{
    private $name;
    private $namespace;
    private $methods = [];
    private $staticMethods = [];
    private $properties = [];
    private $staticProperties = [];
    private $useStatements = [];

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getNamespace()
    {
        return $this->namespace;
    }

    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function addMethod(MethodRepresentation $method)
    {
        if ($method->isStatic()) {
            $this->staticMethods[] = $method;
        } else {
            $this->methods[] = $method;
        }
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function addProperty(PropertyRepresentation $property)
    {
        if ($property->isStatic()) {
            $this->staticProperties[] = $property;
        } else {
            $this->properties[] = $property;
        }
    }

    public function setUseStatements(array $useStatements)
    {
        $this->useStatements = $useStatements;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'namespace' => $this->namespace,
            'methods' => array_map(function (MethodRepresentation $method) {
                return $method->toArray();
            }, $this->methods),
            'staticMethods' => array_map(function (MethodRepresentation $method) {
                return $method->toArray();
            }, $this->staticMethods),
            'properties' => array_map(function (PropertyRepresentation $property) {
                return $property->toArray();
            }, $this->properties),
            'staticProperties' => array_map(function (PropertyRepresentation $property) {
                return $property->toArray();
            }, $this->staticProperties),
            'useStatements' => array_map(function (UseRepresentation $use) {
                return $use->toArray();
            }, $this->useStatements)
        ];
    }
}
