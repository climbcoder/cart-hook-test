<?php

namespace Tests\Unit\Helpers;

use App\Helpers\Sorter;
use PHPUnit\Framework\TestCase;

class SorterTest extends TestCase
{
    public function smallArrays()
    {
        return [
            [
                'original' => [53, 28, 46, 90, 98, 48, 58, 25, 39, 45, 52],
                'sorted' => [25, 28, 39, 45, 46, 48, 52, 53, 58, 90, 98]
            ],
            [
                'original' => [34, 34, 51, 77, 86, 94, 11, 49, 93, 22, 4],
                'sorted' => [4, 11, 22, 34, 34, 49, 51, 77, 86, 93, 94]
            ],
            [
                'original' => [72, 5, 89, 66, 45, 96, 94, 43, 26, 35, 12],
                'sorted' => [5, 12, 26, 35, 43, 45, 66, 72, 89, 94, 96]
            ],
            [
                'original' => [9, 92, 20, 46, 50, 8, 60, 29, 98, 88, 70],
                'sorted' => [8, 9, 20, 29, 46, 50, 60, 70, 88, 92, 98]
            ],
            [
                'original' => [25, 91, 28, 58, 53, 96, 80, 12, 23, 97, 38],
                'sorted' => [12, 23, 25, 28, 38, 53, 58, 80, 91, 96, 97]
            ],
            [
                'original' => [90, 46, 71, 40, 6, 28, 1, 41, 50, 54, 22],
                'sorted' => [1, 6, 22, 28, 40, 41, 46, 50, 54, 71, 90]
            ],
            [
                'original' => [30, 58, 10, 67, 62, 40, 66, 25, 55, 16, 55],
                'sorted' => [10, 16, 25, 30, 40, 55, 55, 58, 62, 66, 67]
            ],
            [
                'original' => [83, 79, 59, 52, 43, 41, 41, 82, 0, 46, 3],
                'sorted' => [0, 3, 41, 41, 43, 46, 52, 59, 79, 82, 83]
            ],
            [
                'original' => [47, 77, 57, 20, 46, 80, 96, 98, 58, 48, 67],
                'sorted' => [20, 46, 47, 48, 57, 58, 67, 77, 80, 96, 98]
            ],
            [
                'original' => [98, 96, 80, 77, 67, 58, 57, 48, 47, 46, 20],
                'sorted' => [20, 46, 47, 48, 57, 58, 67, 77, 80, 96, 98]
            ],
            [
                'original' => [16, 19, 33, 41, 52, 64, 65, 66, 69, 85, 93],
                'sorted' => [16, 19, 33, 41, 52, 64, 65, 66, 69, 85, 93]
            ]
        ];
    }

    /**
     * @test
     */
    public function measureSmallSorts()
    {
        $helper = new Sorter();

        $smallSortTime = 0;
        $nativeSortTime = 0;

        // Test 10^5 test cases
        for ($i = 0; $i < pow(10, 2); $i++) {
            // Generate array of 11 random ints between 0 and 99
            $array = [];
            for ($j = 0; $j < 11; $j++) {
                $array[] = rand(0, 99);
            }
            $smallSortArray = $array;
            $nativeSortArray = $array;

            // Test execution speed of insertion sort
            $beginTime = microtime(true);
            $helper->smallSort($smallSortArray);
            $smallSortTime += microtime(true) - $beginTime;

            // Test native php sort
            $beginTime = microtime(true);
            $helper->nativeSort($nativeSortArray);
            $nativeSortTime += microtime(true) - $beginTime;
        }

        $smallSortTime = $smallSortTime * 1000;
        echo "Small sort time: {$smallSortTime}ms" . PHP_EOL;
        $nativeSortTime = $nativeSortTime * 1000;
        echo "Native sort time: {$nativeSortTime}ms" . PHP_EOL . PHP_EOL;

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function measureLargeSorts()
    {
        $helper = new Sorter();

        $largeSortTime = 0;
        $nativeSortTime = 0;

        $array = [];
        for ($i = 0; $i < 10000; $i++) {
            $a = rand(100, 10000);
            $b = rand(100, 10000);
            // Arbitrary precision numbers are needed
            $array[] = bcpow($a, $b);
        }

        $largeSortArray = $array;
        $nativeSortArray = $array;

        // Test execution speed of insertion sort
        $beginTime = microtime(true);
        $largeSortArray = $helper->largeSort($largeSortArray);
        $largeSortTime += microtime(true) - $beginTime;
        $largeSortTime = $largeSortTime * 1000;
        echo "Large sort time: {$largeSortTime}ms" . PHP_EOL;

        // Test native php sort
        $beginTime = microtime(true);
        $nativeSortArray = $helper->nativeSort($nativeSortArray);
        $nativeSortTime += microtime(true) - $beginTime;
        $nativeSortTime = $nativeSortTime * 1000;
        echo "Native sort time: {$nativeSortTime}ms" . PHP_EOL . PHP_EOL;

        $this->assertTrue(true);
    }

    /**
     * @test
     * @dataProvider smallArrays
     * @param array $original
     * @param array $sorted
     */
    public function nativeSort(array $original, array $sorted)
    {
        $helper = new Sorter();

        $this->assertEquals(
            $helper->nativeSort($original),
            $sorted
        );
    }

    /**
     * @test
     * @dataProvider smallArrays
     * @param array $original
     * @param array $sorted
     */
    public function smallSort(array $original, array $sorted)
    {
        $helper = new Sorter();

        $this->assertEquals(
            $helper->smallSort($original),
            $sorted
        );
    }

    /**
     * @test
     * @dataProvider smallArrays
     * @param array $original
     * @param array $sorted
     */
    public function largeSort(array $original, array $sorted)
    {
        $helper = new Sorter();

        $this->assertEquals(
            $helper->largeSort($original),
            $sorted
        );
    }
}