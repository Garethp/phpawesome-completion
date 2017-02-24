<?php

namespace Indexer\Test;

use Indexer\test\Nested\Dependency;
use Indexer\test\Nested\OtherDependency as Other;

class PHP5Class
{
    /**
     * @var string
     */
    private $testString;
    private $defaultString = 'default';
    private static $staticString = 'static';

    /**
     * @param string $string
     * @param int $other
     * @return void|null
     */
    public function setString($string, $other)
    {
        /** @var int $a */
        $a = $other;
        $this->testString = $string;
    }

    public function getString()
    {
        return $this->testString;
    }

    public function add(int $x, $y): int
    {
        return $x + $y;
    }

    public function nullable(?string $string): ?string
    {
        return $string;
    }

    public static function getStatic(): string
    {
        return self::$staticString;
    }

    public function doSomething(\Indexer\Test\AnotherTestClass $anotherTestClass): \Indexer\Test\AnotherTestClass
    {
    }

    public function transformDependency(Dependency $dependency): Dependency
    {
        return $dependency;
    }

    public function useAs(Other $other): Other
    {
        return $other;
    }
}
?>

<html>Some Stupid HTML</html>
