<?php

namespace Indexer\ContextParser;

use Indexer\Context;
use Indexer\Contexts;
use Indexer\Token;

class NoContext implements ContextParserInterface
{
    public function parse(Context $context, Token $token)
    {
        switch ($token->getToken()) {
            case T_OPEN_TAG:
                $context->changeContext(Contexts::CONTEXT_IN_PHP);
                break;
            default:
                break;
        }
    }
}
