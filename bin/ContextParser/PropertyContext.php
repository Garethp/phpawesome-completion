<?php

namespace Indexer\ContextParser;

use Indexer\Context;
use Indexer\Contexts;
use Indexer\Token;

class PropertyContext implements ContextParserInterface
{
    public function parse(Context $context, Token$token)
    {
        switch ($token->getToken()) {
            case T_WHITESPACE:
                return;
            case T_VARIABLE:
                $context->getProperty()->setName($token->getValue());
                return;
            case ';':
                if ($context->getDocblock() && $context->getDocblock()->isForProperty()) {
                    $context->getProperty()->addTypes($context->getDocblock()->getVariableTypes());
                }

                $context->getClass()->addProperty($context->getProperty());
                $context->clearProperty();
                $context->clearDocblock();
                $context->leaveContext();
                return;
            case '=':
                $context->getProperty()->addLinesSetAt($token->getLineNumber());
                return;
            case T_CONSTANT_ENCAPSED_STRING:
                $context->getProperty()->addType('string');
                break;
            default:
                return;
        }
    }
}
