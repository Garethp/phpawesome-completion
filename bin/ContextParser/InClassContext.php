<?php

namespace Indexer\ContextParser;

use Indexer\Context;
use Indexer\Contexts;
use Indexer\Representation\DocblockRepresentation;
use Indexer\Token;

class InClassContext implements ContextParserInterface
{
    public function parse(Context $context, Token $token)
    {
        switch ($token->getToken()) {
            case T_STATIC:
                $context->getTokens()->next();
                $context->makeStatic();
                break;
            case T_PROTECTED:
                $context->getTokens()->next();
                $context->setVisibility('protected');
                break;
            case T_PRIVATE:
                $context->getTokens()->next();
                $context->setVisibility('private');
                break;
            case T_PUBLIC:
                $context->getTokens()->next();
                $context->setVisibility('public');
                break;
            case T_DOC_COMMENT:
                $context->setDocblock(new DocblockRepresentation($token->getValue()));
                break;
            case T_VARIABLE:
                $context->createNewProperty();
                $context->changeContext(Contexts::CONTEXT_PROPERTY);
                $context->getTokens()->previous();
                break;
            case T_FUNCTION:
                $context->changeContext(Contexts::CONTEXT_SIGNATURE_METHOD);
                $context->createNewMethod();
                break;
            case '}':
                $context->leaveContext();
                break;
            default:
                break;
        }
    }
}
