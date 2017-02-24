<?php

namespace Indexer\ContextParser;

use Indexer\Context;
use Indexer\Contexts;
use Indexer\Token;

class NamespaceContext implements ContextParserInterface
{
    public function parse(Context $context, Token $token)
    {
        switch ($token->getToken()) {
            case T_WHITESPACE:
                return;
            case T_STRING:
                $context->setNamespace($context->getNamespace() . $token->getValue());
                return;
            case T_NS_SEPARATOR:
                $context->setNamespace($context->getNamespace() . "\\");
                return;
            case ';':
                $context->leaveContext();
                return;
        }
    }
}
