<?php

namespace Indexer\Representation;

class MethodRepresentation
{
    private $visibility = 'public';
    private $name;
    private $arguments = [];
    private $returnTypes = [];
    private $php7ReturnType = false;
    private $static = false;

    public function setVisibility($visibility)
    {
        if ($visibility === null) {
            return;
        }

        $this->visibility = $visibility;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function addArgument(ArgumentRepresentation $argument)
    {
        if ($argument->getName() === null) {
            return;
        }

        $this->arguments[] = $argument;
    }

    public function addReturnType(string $type)
    {
        if ($this->php7ReturnType && !empty($this->returnTypes)) {
            return;
        }

        $this->returnTypes[] = $type;
    }

    public function markReturnTypeAsPHP7()
    {
        $this->php7ReturnType = true;
    }

    public function isStatic(): bool
    {
        return $this->static;
    }

    public function setStatic(bool $static)
    {
        $this->static = $static;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'visibility' => $this->visibility,
            'arguments' => array_map(function (ArgumentRepresentation $argument) {
                return $argument->toArray();
            }, $this->arguments),
            'returnTypes' => $this->returnTypes
        ];
    }
}
