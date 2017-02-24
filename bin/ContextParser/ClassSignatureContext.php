<?php

namespace Indexer\ContextParser;

use Indexer\Context;
use Indexer\Contexts;
use Indexer\Token;

class ClassSignatureContext implements ContextParserInterface
{
    public function parse(Context $context, Token $token)
    {
        switch ($token->getToken()) {
            case '{':
                $context->leaveContext();
                $context->changeContext(Contexts::CONTEXT_IN_CLASS);
                break;
            default:
                break;
        }
    }
}
