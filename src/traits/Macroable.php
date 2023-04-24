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


}