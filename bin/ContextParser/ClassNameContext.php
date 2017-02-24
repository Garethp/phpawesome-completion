<?php

namespace Indexer\ContextParser;

use Indexer\Context;
use Indexer\Contexts;
use Indexer\Token;

class ClassNameContext implements ContextParserInterface
{
    public function parse(Context $context, Token $token)
    {
        switch ($token->getToken()) {
            case T_STRING:
                $context->getClass()->setName($token->getValue());
                break;
            case T_WHITESPACE:
                $context->leaveContext();
                break;
        }
    }
}
