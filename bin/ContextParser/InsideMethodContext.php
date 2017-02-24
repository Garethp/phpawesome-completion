<?php

namespace Indexer\ContextParser;

use Indexer\Context;
use Indexer\Contexts;
use Indexer\Representation\DocblockRepresentation;
use Indexer\Token;

class InsideMethodContext implements ContextParserInterface
{
    public function parse(Context $context, Token $token)
    {
        switch ($token->getToken()) {
            case '}':
                if ($context->getBraceDepth() === 1) {
                    $context->leaveContext();

                    $context->getClass()->addMethod($context->getMethod());
                    $context->clearMethod();
                }
                return;
            case T_DOC_COMMENT:
                $docblock = new DocblockRepresentation($token->getValue());
                return;
            default:
                return;
        }
    }
}
