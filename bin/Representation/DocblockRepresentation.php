<?php

namespace Indexer\Representation;

class DocblockRepresentation
{
    private $varTypes = [];
    private $varName;
    private $returnTypes = [];
    private $params = [];
    private $deprecated = false;

    public function __construct(string $docblock)
    {
        preg_match("~@var ([\S]+)(?:\s([\S]+))?~", $docblock, $varMatches);
        if (count($varMatches) === 2) {
            $this->varTypes = explode("|", $varMatches[1]);
        } elseif (count($varMatches) === 3) {
            $this->varName = $varMatches[1];
            $this->varTypes = explode("|", $varMatches[2]);
        }

        preg_match("~@return ([\S]+)~", $docblock, $returnMatches);
        if (count($returnMatches) == 2) {
            $this->returnTypes = explode("|", $returnMatches[1]);
        }

        preg_match_all("~@param ([\S]+) ([\S]+)~", $docblock, $paramMatches);
        foreach ($paramMatches[2] as $key => $paramName) {
            $this->params[$paramName] = explode("|", $paramMatches[1][$key]);
        }

        if (preg_match("~@deprecated~", $docblock)) {
            $this->deprecated = true;
        }
    }

    public function getVariableTypes(): array
    {
        return $this->varTypes;
    }

    public function getVariableName(): ?string
    {
        return $this->varName;
    }

    public function getReturnTypes(): array
    {
        return $this->returnTypes;
    }

    public function hasParameterReturnType(string $name)
    {
        if (!$this->isForMethod() || !isset($this->params[$name])) {
            return false;
        }

        return true;
    }

    public function getParameterReturnType(string $name)
    {
        return $this->params[$name];
    }

    public function isDeprecated(): bool
    {
        return $this->deprecated;
    }

    public function isForMethod()
    {
        return count($this->params) || $this->returnType;
    }

    public function isForProperty()
    {
        return !empty($this->varTypes);
    }

    public function isForVariable()
    {
        return $this->varName !== null;
    }
}
