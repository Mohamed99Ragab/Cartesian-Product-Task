<?php

namespace App\Services;

use InvalidArgumentException;

class CartesianProductWithoutGenerator
{
    
static function  cartesianProduct(...$arrays) {
    
    $callback = null;

    // If the last element is a callable (callback)
    if (is_callable(end($arrays))) {
        $callback = array_pop($arrays); // Remove the last element and store it
    }

    // Validate that all inputs are arrays
    foreach ($arrays as $array) {
        if (!is_array($array)) {
            throw new InvalidArgumentException("All arguments must be arrays.");
        }

        if (empty($array)) {
            return [];
        }
    }

    // Case of a single array only
    if (count($arrays) === 1) {
        $result = array_map(fn($item) => [$item], $arrays[0]);
        return $callback ? array_map($callback, $result) : $result;
    }

    $result = [[]]; // Start with an empty array

    foreach ($arrays as $array) {
        $newResult = [];
        foreach ($result as $product) {
            foreach ($array as $item) {
                $newResult[] = array_merge($product, [$item]);
            }
        }
        $result = $newResult;
    }

    return $callback ? array_map($callback, $result) : $result;
}
}
