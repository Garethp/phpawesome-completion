<?php

namespace Indexer\Representation;

class UseRepresentation
{
    private $class;

    private $as;

    public function setClass(string $class)
    {
        $this->class = $class;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setAs(string $as)
    {
        $this->as = $as;
    }

    public function getAs(): string
    {
        if ($this->class === null) {
            return '';
        }

        if ($this->as === null) {
            $explodedAs = explode("\\", $this->class);
            return array_pop($explodedAs);
        }

        return $this->as;
    }

    public function appendAs(string $as)
    {
        $this->as .= $as;
    }

    public function toArray(): array
    {
        return [
            'class' => $this->getClass(),
            'as' => $this->getAs()
        ];
    }
}
