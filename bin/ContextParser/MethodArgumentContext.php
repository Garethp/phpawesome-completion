<?php

namespace Indexer\ContextParser;

use Indexer\Context;
use Indexer\Contexts;
use Indexer\Token;

class MethodArgumentContext implements ContextParserInterface
{
    public function parse(Context $context, Token $token)
    {
        switch ($token->getToken()) {
            case T_WHITESPACE:
                return;
            case '?':
                $context->getArgument()->addType('null');
                break;
            case T_NS_SEPARATOR:
                $context->setStringBuffer($context->getStringBuffer() . "\\");
                return;
            case T_STRING:
                $context->setStringBuffer($context->getStringBuffer() . $token->getValue());
                return;
            case T_VARIABLE:
                $context->getArgument()->setName($token->getValue());
                return;
            case ')':
                $this->addArgument($context);
                $context->clearArgument();
                $context->leaveContext();
                return;
            case ',':
                $this->addArgument($context);
                return;
            default:
                return;
        }
    }

    private function addArgument(Context $context)
    {
        if (!$context->getArgument()->getName()) {
            return;
        }

        $argumentType = $context->getFullyQualifiedClassName($context->getStringBuffer());
        $context->clearStringBuffer();
        if ($argumentType !== null) {
            $context->getArgument()->addType($argumentType);
            $context->getArgument()->markPHP7Type();
        }
        if ($context->getDocblock() &&
            $context->getDocblock()->isForMethod() &&
            $context->getDocblock()->hasParameterReturnType($context->getArgument()->getName())
        ) {
            foreach ($context->getDocblock()->getParameterReturnType($context->getArgument()->getName()) as $type) {
                $context->getArgument()->addType($type);
            }
        }

        $context->getMethod()->addArgument($context->getArgument());
        $context->setIsNullable(false);
        $context->createNewArgument();
    }
}
