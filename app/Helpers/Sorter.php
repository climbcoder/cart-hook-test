<?php

namespace App\Helpers;

/**
 * Insertion sort will be faster for small arrays despite having a worst Big-O complexity, due to less overhead for
 * recursive calls of other algorithm, as well as the fact that Big-O notation ignores constant factors like single
 * operations (additions, etc).
 * If sorting a single list of 11 elements with insertion sort takes on average s seconds, sorting 10^10 lists of 11
 * elements will take on average s * 10^10 seconds, where s depends on how fast the machine is.
 * The complexity scales linearly with the number of arrays to sort, and by a factor of n^2 with the size of the array.
 *
 * Quicksort will be used for large arrays. On my computer, Quicksort sorts an array of 1000 arbitrary precision large
 * integers in around 45 seconds, compared to 650 seconds of the native PHP sort function.
 * Sorting 10000 numbers should increase the computation time by a factor of 10 * 2log_{4/3}(10).
 * https://en.wikipedia.org/wiki/Quicksort#Average-case_analysis
 *
 * Native sort is provided for comparison. It can sometimes run faster because it calls native PHP functions in C.
 *
 * Class Sorter
 * @package App\Helpers
 */
class Sorter
{
    /**
     * @param array $numbers
     * @return array
     */
    public function smallSort(array $numbers): array
    {
        return $this->insertionSort($numbers);
    }

    /**
     * @param array $numbers
     * @return array
     */
    public function largeSort(array $numbers): array
    {
        $this->quickSort($numbers, 0, count($numbers) - 1);
        return $numbers;
    }

    /**
     * Insertion sort implementation
     *
     * @param array $numbers
     * @return array
     */
    private function insertionSort(array $numbers): array
    {
        for ($i = 0; $i < count($numbers); $i++) {
            $current = $numbers[$i];
            $comparing = $i - 1;
            while ($comparing >= 0 && $numbers[$comparing] > $current) {
                $numbers[$comparing + 1] = $numbers[$comparing];
                $comparing--;
            }
            $numbers[$comparing + 1] = $current;
        }
        return $numbers;
    }

    /**
     * Sort with php native function
     *
     * @param array $numbers
     * @return array
     */
    public function nativeSort(array $numbers): array
    {
        sort($numbers, SORT_NUMERIC);
        return $numbers;
    }

    /**
     * Quicksort implementation
     *
     * @param array $numbers
     * @param int   $left
     * @param int   $right
     */
    private function quickSort(array &$numbers, int $left = 0, int $right = null)
    {
        // Init
        $pivot = $left;
        $right = is_null($right) ? count($numbers) - 1 : $right;

        // Nothing to sort
        if ($right - $left < 1) {
            return;
        }

        // Move median value to the back to avoid bad performance when sorting an already sorted array
        $this->swap($numbers, (int)(($left + $right) / 2), $right);

        // Sort from left to right
        for ($i = $left; $i < $right; $i++) {
            if ($numbers[$i] < $numbers[$right]) {
                $this->swap($numbers, $i, $pivot);
                $pivot++;
            }
        }

        // Placing last value between the two split arrays
        $this->swap($numbers, $pivot, $right);

        // Sorting left of the pivot
        $this->quickSort($numbers, $left, $pivot - 1);

        // Sorting right of the pivot
        $this->quickSort($numbers, $pivot + 1, $right);
    }

    /**
     * Swap two element in an array
     *
     * @param $array
     * @param $a
     * @param $b
     */
    protected function swap(&$array, $a, $b)
    {
        if ($a !== $b) {
            $temp = $array[$a];
            $array[$a] = $array[$b];
            $array[$b] = $temp;
        }
    }
}
