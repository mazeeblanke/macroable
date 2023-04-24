<?php 

namespace Mazeeblanke\Macroable\traits;

trait Macroable {
    /**
     * A list of macros
     *
     * @var [type]
     */
    protected static $macros = [];

    /**
     * A function to add macros
     *
     * @param   string    $name      
     * @param   callable  $callback
     *
     * @return  void
     */
    public static function macro(string $name, callable $callback): void
    {
        static::$macros[$name] = $callback;
    }

    /**
     * Reset the macros array to empty state
     *
     * @return  void
     */
    public static function flushMacros(): void
    {
        static::$macros = [];
    }

    /**
     * Check if macro exists
     *
     * @param   string  $macro
     *
     * @return  bool
     */
    public function hasMacro(string $macro): bool
    {
        return isset(static::$macros[$macro]);
    }
}