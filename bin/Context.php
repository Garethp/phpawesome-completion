<?php

namespace Indexer;

use Indexer\Representation\ArgumentRepresentation;
use Indexer\Representation\ClassRepresentation;
use Indexer\Representation\DocblockRepresentation;
use Indexer\Representation\MethodRepresentation;
use Indexer\Representation\PropertyRepresentation;
use Indexer\Representation\UseRepresentation;

class Context
{
    private $tokens;
    private $currentContext = Contexts::CONTEXT_NONE;
    private $contexts = [Contexts::CONTEXT_NONE];
    private $namespace = '';
    private $currentClass;
    private $currentMethod;
    private $property;
    private $visibility;
    private $nullable = false;
    private $argument;
    private $braceDepth = 0;
    private $static = false;
    private $stringBuffer;
    private $useStatements = [];
    private $useAsFlag = false;
    private $useStatement;
    private $docblock;

    public function __construct(TokenCollection $tokens)
    {
        $this->tokens = $tokens;
    }

    public function getTokens()
    {
        return $this->tokens;
    }

    public function changeContext(?string $currentContext)
    {
        $this->currentContext = $currentContext;
        $this->contexts[] = $currentContext;
    }
    public function getContext(): ?string
    {
        return end($this->contexts);
    }
    public function leaveContext()
    {
        array_pop($this->contexts);
    }
    public function leaveContextUntil($context)
    {
        if (end($this->contexts) !== $context) {
            array_pop($this->contexts);
        }

        if (!count($this->contexts)) {
            $this->contexts = [Contexts::CONTEXT_NONE];
        }
    }

    public function getNamespace(): ?string
    {
        return $this->namespace;
    }
    public function setNamespace(?string $namespace)
    {
        $this->namespace = $namespace;
    }

    public function getClass(): ?ClassRepresentation
    {
        return $this->currentClass;
    }
    public function clearClass()
    {
        $this->currentClass = null;
    }
    public function createNewClass()
    {
        $this->currentClass = new ClassRepresentation();
        $this->currentClass->setUseStatements($this->useStatements);
    }

    public function getMethod(): ?MethodRepresentation
    {
        return $this->currentMethod;
    }
    public function clearMethod()
    {
        $this->currentMethod = null;
    }
    public function createNewMethod()
    {
        $this->currentMethod = new MethodRepresentation();
        $this->currentMethod->setVisibility($this->visibility);
        $this->currentMethod->setStatic($this->static);
        $this->clearStatic();
        $this->clearVisibility();
    }

    public function getArgument(): ?ArgumentRepresentation
    {
        return $this->argument;
    }
    public function clearArgument()
    {
        $this->argument = null;
    }
    public function createNewArgument()
    {
        $this->argument = new ArgumentRepresentation();
    }

    public function getProperty(): ?PropertyRepresentation
    {
        return $this->property;
    }
    public function createNewProperty()
    {
        $this->property = new PropertyRepresentation();
        $this->property->setVisibility($this->visibility);
        $this->property->setStatic($this->static);
        $this->clearVisibility();
        $this->clearStatic();
    }
    public function clearProperty()
    {
        $this->property = null;
    }

    public function getVisibility(): ?string
    {
        return $this->visibility;
    }
    public function setVisibility(string $visibility)
    {
        $this->visibility = $visibility;
    }
    public function clearVisibility()
    {
        $this->visibility = null;
    }

    public function getBraceDepth(): int
    {
        return $this->braceDepth;
    }
    public function increaseBraceDepth()
    {
        $this->braceDepth++;
    }
    public function decreaseBraceDepth()
    {
        $this->braceDepth--;
    }

    public function isNullable(): bool
    {
        return $this->nullable;
    }
    public function setIsNullable(bool $isNullable)
    {
        $this->nullable = $isNullable;
    }

    public function isStatic(): bool
    {
        return $this->static;
    }
    public function makeStatic()
    {
        $this->static = true;
    }
    public function clearStatic()
    {
        $this->static = false;
    }

    public function getStringBuffer(): ?string
    {
        return $this->stringBuffer;
    }
    public function setStringBuffer(?string $string)
    {
        $this->stringBuffer = $string;
    }
    public function clearStringBuffer()
    {
        $this->stringBuffer = null;
    }

    public function getUseStatement(): ?UseRepresentation
    {
        return $this->useStatement;
    }
    public function createNewUseStatement()
    {
        $this->useStatement = new UseRepresentation();
    }
    public function clearUseStatement()
    {
        $this->useStatement = null;
    }

    public function addUseStatement(UseRepresentation $use)
    {
        $this->useStatements[] = $use;
    }
    public function getFullyQualifiedClassName(?string $className)
    {
        if ($className === null) {
            return null;
        }

        if (substr($className, 0, 1) === "\\") {
            return $className;
        }

        $explodedClassName = explode("\\", $className);
        $firstPart = array_shift($explodedClassName);
        /** @var UseRepresentation $use */
        foreach ($this->useStatements as $use) {
            if ($use->getAs() === $firstPart) {
                $full = explode("\\", $use->getClass());
                $full = $full + $explodedClassName;
                return "\\" . implode("\\", $full);
            }
        }

        return "\\" . $className;
    }

    public function getUseAsFlag(): bool
    {
        return $this->useAsFlag;
    }
    public function setUseAsFlag(bool $flag)
    {
        $this->useAsFlag = $flag;
    }

    public function getDocblock(): ?DocblockRepresentation
    {
        return $this->docblock;
    }
    public function setDocblock(DocblockRepresentation $docblock)
    {
        $this->docblock = $docblock;
    }
    public function clearDocblock()
    {
        $this->docblock = null;
    }
}

