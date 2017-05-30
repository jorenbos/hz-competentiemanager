<?php

namespace App\Rounding;

interface RoundingInterface
{

    /**
     * Rounds off an array of numbers
     *
     * @param double[] $unroundenArray | Also works with floats because PHP
     *
     * @return int[]
     */
    public function roundOff($unroundedArray);
}
