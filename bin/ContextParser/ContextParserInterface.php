<?php

namespace Indexer\ContextParser;

use Indexer\Context;
use Indexer\Token;

interface ContextParserInterface
{
    public function parse(Context $context, Token $token);
}
