<?php

namespace Indexer\ContextParser;

use Indexer\Context;
use Indexer\Contexts;
use Indexer\Representation\DocblockRepresentation;
use Indexer\Token;

class InPHPContext implements ContextParserInterface
{
    public function parse(Context $context, Token $token)
    {
        switch ($token->getToken()) {
            case T_CLOSE_TAG:
                $context->leaveContextUntil(Contexts::CONTEXT_NONE);
                break;
            case '{':
                $context->changeContext(Contexts::CONTEXT_IN_CLASS);
                break;
            case T_NAMESPACE:
                $context->getTokens()->next();
                $context->setNamespace('');
                $context->changeContext(Contexts::CONTEXT_NAMESPACE);
                break;
            case T_CLASS:
                $context->getTokens()->next();
                $context->createNewClass();
                $context->getClass()->setNamespace($context->getNamespace());
                $context->changeContext(Contexts::CONTEXT_CLASS_SIGNATURE);
                $context->changeContext(Contexts::CONTEXT_CLASS_NAME);
                break;
            case T_USE:
                $context->changeContext(Contexts::CONTEXT_USE_STATEMENT);
                $context->createNewUseStatement();
                $context->clearStringBuffer();
                $context->getTokens()->next();
                break;
            default:
                break;
        }
    }
}
