<?php

namespace Indexer\Representation;

class PropertyRepresentation
{
    private $visibility = 'public';

    private $name;

    private $types = [];

    private $linesSetAt = [];

    private $static = false;

    public function getVisibility()
    {
        return $this->visibility;
    }

    public function setVisibility($visibility)
    {
        if ($visibility == null) {
            $visibility = 'public';
        }

        $this->visibility = $visibility;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param mixed $type
     */
    public function addType($type)
    {
        if (in_array($type, $this->types, true)) {
            return;
        }

        $this->types[] = $type;
    }

    public function addTypes(array $types)
    {
        foreach ($types as $type) {
            $this->addType($type);
        }
    }

    public function getLinesSetAt()
    {
        return $this->linesSetAt;
    }

    public function addLinesSetAt(int $lineNumber)
    {
        $this->linesSetAt[] = $lineNumber;
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
            'visiblity' => $this->visibility,
            'name' => $this->name,
            'types' => $this->types
        ];
    }
}
