<?php 

namespace Mazeeblanke\Macroable\traits;

use BadMethodCallException;
use PhpParser\Node\Expr\Closure;

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
    public static function hasMacro(string $macro): bool
    {
        return isset(static::$macros[$macro]);
    }

    /**
     * Handle dynamic calls to class
     *
     * @param   string  $method   
     * @param   array   $parameters 
     *
     * @return  mixed 
     */
    public function __call(string $method, array $parameters): mixed
    {
        if (!static::hasMacro($method)) {
            throw new BadMethodCallException(sprintf(
                'Method %s::%s does not exist', static::class, $method
            )) ;
        }

        $macro = static::$macros[$method];

        if ($macro instanceof Closure) {
            $macro = $macro->bindTo($this, static::class);
        }

        return $macro(...$parameters);
    }
}