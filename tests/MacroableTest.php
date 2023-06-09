<?php

use Mazeeblanke\Macroable\traits\Macroable;
use PHPUnit\Framework\TestCase;

class MacroableTest extends TestCase {
    use Macroable;

    protected function tearDown(): void
    {
        parent::tearDown();
        static::$macros = [];
    }

    public function test_can_add_new_macroables()
    {
        $this->generateMacro();

        $this->assertCount(1, static::$macros);

        $this->generateMacro();

        $this->assertCount(2, static::$macros);
    }

    public function test_can_flush_macros()
    {
        $macrosNum = 10;

        $this->generateMacro($macrosNum);

        $this->assertCount($macrosNum, static::$macros);

        static::flushMacros();

        $this->assertCount(0, static::$macros);
    }

    public function test_macro_check_exist()
    {
        $this->assertFalse(static::hasMacro('test'));

        static::macro('test', function () {
            return 'test';
        });

        $this->assertTrue(static::hasMacro('test'));
    }

    public function generateMacro($number = 1) {
        $index = 0;

        while ($index < $number) {
            static::macro(bin2hex(random_bytes(10)), function() {
                return 'test';
            });

            $index++;
        }
    }

    public function test_throws_exception_on_dynamic_call_to_unavailable_macro()
    {
        $this->expectException(BadMethodCallException::class);

        $this->testMacro();
    }

    public function test_can_trigger_macros_dynamically()
    {
        static::macro('test', function () {
            return 'test';
        });

        $this->assertEquals('test', $this->test());
    }
}