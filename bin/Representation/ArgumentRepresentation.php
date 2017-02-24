<?php

namespace Indexer\Representation;

class ArgumentRepresentation
{
    private $types = [];
    private $name;
    private $nullable = false;
    private $php7Type = false;

    public function getType(): ?string
    {
        return $this->types;
    }

    public function addType(?string $type)
    {
        if ($this->php7Type || $type === null) {
            return;
        }

        $this->types[] = $type;
    }

    public function setNullable(bool $nullable)
    {
        $this->nullable = $nullable;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function markPHP7Type()
    {
        $this->php7Type = true;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'types' => $this->types
        ];
    }
}
