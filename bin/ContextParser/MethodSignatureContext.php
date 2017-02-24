<?php

namespace Indexer\ContextParser;

use Indexer\Context;
use Indexer\Contexts;
use Indexer\Token;

class MethodSignatureContext implements ContextParserInterface
{
    public function parse(Context $context, Token $token)
    {
        switch ($token->getToken()) {
            case T_WHITESPACE:
                return;
            case T_STRING:
                $context->getMethod()->setName($token->getValue());
                return;
            case '(':
                $context->createNewArgument();
                $context->changeContext(Contexts::CONTEXT_METHOD_ARGUMENT);
                return;
            case '{':
                if ($context->getBraceDepth() === 2) {
                    $context->leaveContext();
                    $context->changeContext(Contexts::CONTEXT_METHOD_IN_METHOD);
                }
                return;
            case ':':
                $context->changeContext(Contexts::CONTEXT_METHOD_RETURN_TYPE);
                return;
            default:
                return;
        }
    }
}
