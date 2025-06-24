<?php

namespace App\Services;

use InvalidArgumentException;

class CartesianProduct
{
    
    static function cartesianProduct(...$arrays)
    {
        $callback = null;

    // If the last element is a callable (callback)
        if (is_callable(end($arrays))) {
            $callback = array_pop($arrays); // Remove the last element and store it
        }

        // Validate all inputs are arrays and not empty
        foreach ($arrays as $array) {
            if (!is_array($array)) {
                throw new InvalidArgumentException("All arguments must be arrays.");
            }
            if (empty($array)) {
                yield [];
                return;
            }
        }

        // Pass the callback to the generator
        yield from self::cartesianProductGenerator($arrays, [], $callback);
    }

    /**
     * Recursive generator helper.
     */
    private static function cartesianProductGenerator($arrays, $prefix, $callback = null)
    {
        if (empty($arrays)) {
            // Apply callback if provided
            yield $callback ? $callback($prefix) : $prefix;
        } else {
            $first = array_shift($arrays);
            foreach ($first as $item) {
                yield from self::cartesianProductGenerator($arrays, array_merge($prefix, [$item]), $callback);
            }
        }
    }
}
