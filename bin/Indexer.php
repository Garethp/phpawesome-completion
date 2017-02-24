<?php

namespace Indexer;

use Indexer\ContextParser\ContextFactory;

class Indexer
{
    /**
     * @var Context
     */
    private $context;

    private function index(string $filename)
    {
        $tokens = $this->getTokens($filename);
        $this->context = new Context(new TokenCollection($tokens));

        $contextParserFactory = new ContextFactory();

        foreach ($this->context->getTokens() as $token) {
            if ($token->getToken() === '{') {
                $this->context->increaseBraceDepth();
            }

            if ($token->getToken() === '}') {
                $this->context->decreaseBraceDepth();
            }

            $contextParserFactory->getParser($this->context->getContext())->parse($this->context, $token);
        }

        return $this->context;
    }

    public function indexAndWrite(string $outputFilename, $inputFilename)
    {
        $context = $this->index($inputFilename);
        file_put_contents($outputFilename, json_encode($context->getClass()->toArray()));
    }

    protected function getTokens(string $filename): array
    {
        $file = file_get_contents($filename);
        return token_get_all($file);
    }
}
