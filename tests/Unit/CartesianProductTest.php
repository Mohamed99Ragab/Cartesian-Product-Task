<?php

use App\Services\CartesianProduct;
use PHPUnit\Framework\TestCase;

class CartesianProductTest extends TestCase
{
    public function testCartesianProductNormal()
    {
        // Arrange
        $array1 = [1, 2];
        $array2 = ['a', 'b'];
        $expected = [
            [1, 'a'],
            [1, 'b'],
            [2, 'a'],
            [2, 'b']
        ];

        // Act
        $result = iterator_to_array(CartesianProduct::cartesianProduct($array1, $array2), false);

        // Assert
        $this->assertEquals($expected, $result);
    }

    public function testCartesianProductWithEmptyArray()
    {
        // Arrange
        $array1 = [1, 2];
        $array2 = [];
        $expected = [
            []
        ];

        // Act
        $result = iterator_to_array(CartesianProduct::cartesianProduct($array1, $array2), false);

        // Assert
        $this->assertEquals($expected, $result);
    }

    public function testCartesianProductSingleArray()
    {
        // Arrange
        $array = [5, 6];
        $expected = [
            [5],
            [6]
        ];

        // Act
        $result = iterator_to_array(CartesianProduct::cartesianProduct($array), false);

        // Assert
        $this->assertEquals($expected, $result);
    }

    public function testCartesianProductThreeArrays()
    {
        // Arrange
        $array1 = [1, 2];
        $array2 = ['a'];
        $array3 = ['X', 'Y'];
        $expected = [
            [1, 'a', 'X'],
            [1, 'a', 'Y'],
            [2, 'a', 'X'],
            [2, 'a', 'Y']
        ];

        // Act
        $result = iterator_to_array(CartesianProduct::cartesianProduct($array1, $array2, $array3), false);

        // Assert
        $this->assertEquals($expected, $result);
    }

    public function testCartesianProductLargeArrays()
    {
        // Arrange
        $array1 = range(1, 1000);
        $array2 = range(1001, 2000);

        // Act
        $generator = CartesianProduct::cartesianProduct($array1, $array2);

        // Assert
        $count = 0;
        $first = null;
        $last = null;
        foreach ($generator as $combo) {
            if ($count === 0) {
                $first = $combo;
            }
            $last = $combo;
            $count++;
        }

        // There should be exactly 1,000,000 combinations
        $this->assertEquals(1000000, $count);

        // First combination should be [1, 1001]
        $this->assertEquals([1, 1001], $first);

        // Last combination should be [1000, 2000]
        $this->assertEquals([1000, 2000], $last);
    }
}
