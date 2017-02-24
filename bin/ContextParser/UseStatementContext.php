<?php

namespace Indexer\ContextParser;

use Indexer\Context;
use Indexer\Contexts;
use Indexer\Representation\UseRepresentation;
use Indexer\Token;

class UseStatementContext implements ContextParserInterface
{
    public function parse(Context $context, Token $token)
    {
        switch ($token->getToken()) {
            case T_NS_SEPARATOR:
                if (!$context->getUseAsFlag()) {
                    $context->getUseStatement()->setClass($context->getUseStatement()->getClass() . "\\");
                } else {
                    $context->getUseStatement()->appendAs("\\");
                }
                return;
            case T_STRING:
                if (!$context->getUseAsFlag()) {
                    $context->getUseStatement()->setClass($context->getUseStatement()->getClass() . $token->getValue());
                } else {
                    $context->getUseStatement()->appendAs($token->getValue());
                }
                return;
            case T_AS:
                $context->setUseAsFlag(true);
                break;
            case ';':
                $context->addUseStatement($context->getUseStatement());
                $context->clearUseStatement();
                $context->setUseAsFlag(false);
                $context->leaveContext();
                return;
            default:
                return;
        }
    }
}
