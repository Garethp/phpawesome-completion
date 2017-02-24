<?php

namespace Indexer\ContextParser;

class ContextFactory
{
    public function hasParser(?string $name): bool
    {
        if ($name === null) {
            return false;
        }

        return class_exists("\\Indexer\\ContextParser\\$name");
    }

    public function getParser(string $name): ContextParserInterface
    {
        $class = "\\Indexer\\ContextParser\\$name";
        return new $class;
    }
}
