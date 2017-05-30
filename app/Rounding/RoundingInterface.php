<?php

namespace App\Rounding;

interface RoundingInterface
{
    /**
     * Rounds off an array of numbers.
     *
     * @param float[] $unroundenArray | Also works with floats because PHP
     *
     * @return int[]
     */
    public function roundOff($unroundedArray);
}
