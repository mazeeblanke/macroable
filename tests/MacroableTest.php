<?php

use Mazeeblanke\Macroable\traits\Macroable;
use PHPUnit\Framework\TestCase;

class MacroableTest extends TestCase {
    use Macroable;

    public function test_can_add_new_macroables()
    {
        static::macro('test', function() {
            return 'test';
        });

        $this->assertCount(1, static::$macros);

        static::macro('test2', function() {
            return 'test 2';
        });

        $this->assertCount(2, static::$macros);
    }
}