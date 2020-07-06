<?php

namespace App\Helpers;

class ExceptionFormatter
{
    /**
     * @param string $message
     * @param int $depth
     * @return string
     */
    public static function f(string $message, int $depth = 1): string
    {
        $tree = debug_backtrace();
        if (true === key_exists($depth, $tree)) {
            $node = $tree[$depth];
            $message = "{$node['class']}->{$node['function']}: {$message}";
        }

        return $message;
    }
}
