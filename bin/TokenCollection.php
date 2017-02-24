<?php

namespace Indexer;

class TokenCollection implements \Iterator
{
    private $tokens;
    private $position;

    public function __construct(array $tokens)
    {
        $lineNumber = 0;
        $tokens = array_map(function ($token) use (&$lineNumber): Token {
            if (is_array($token)) {
                $lineNumber = $token[2];
            } else {
                $token = [$token, $token, $lineNumber];
            }
            return new Token($token);
        }, $tokens);
        $this->tokens = $tokens;
    }

    public function current()
    {
        return $this->tokens[$this->position];
    }

    public function next()
    {
        $this->position++;
    }

    public function previous()
    {
        $this->position--;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return isset($this->tokens[$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
    }
}
