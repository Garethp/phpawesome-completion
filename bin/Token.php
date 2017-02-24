<?php

namespace Indexer;

class Token
{
    protected $token;

    protected $tokenName;

    protected $value;

    protected $line;

    public function __construct($token)
    {
        $this->token = $token[0];
        $this->tokenName = is_numeric($token[0]) ? token_name($token[0]) : null;
        $this->value = $token[1];
        $this->line = $token[2];
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getLineNumber(): int
    {
        return $this->line;
    }

    public function getTokenArray()
    {
        return array_filter([
            'token' => $this->tokenName ? $this->tokenName : $this->token,
            'value' => $this->value,
            'line' => $this->line
        ]);
    }
}
