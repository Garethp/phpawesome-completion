<?php

namespace Indexer\ContextParser;

use Indexer\Context;
use Indexer\Contexts;
use Indexer\Token;

class MethodReturnTypeContext implements ContextParserInterface
{
    public function parse(Context $context, Token $token)
    {
        switch ($token->getToken()) {
            case T_WHITESPACE:
                return;
            case '{':
                $type = $context->getFullyQualifiedClassName($context->getStringBuffer());
                $context->getMethod()->addReturnType($type);
                $context->clearStringBuffer();
                if ($context->isNullable()) {
                    $context->getMethod()->addReturnType('null');
                }
                $context->setIsNullable(false);
                $context->getMethod()->markReturnTypeAsPHP7();

                $context->leaveContext();
                $context->leaveContext();
                $context->changeContext(Contexts::CONTEXT_METHOD_IN_METHOD);
                return;
            case T_NS_SEPARATOR:
            case T_STRING:
                $context->setStringBuffer($context->getStringBuffer() . $token->getValue());
                return;
            case '?':
                $context->setIsNullable(true);
                return;
            default:
                return;
        }
    }
}
