<?php

namespace App\Rounding\RoundingImplementation;

use App\Rounding\RoundingInterface;

class ProportionalRepresentation implements RoundingInterface
{
    /**
     * @var Array's
     */
    private $baseArray;
    private $surplusArray;
    private $roundedArray;

    /**
     * @var doubles
     */
    private $roundByValue;
    private $toDistribute;

    public function __construct ($roundByValue)
    {
        $this->roundByValue = $roundByValue;
    }

    /**
     * Rounds off an array of numbers, using Proportional Representation
     *
     * @param double[] $unroundenArray | Also works with floats because PHP
     *
     * @return int[]
     */
    public function roundOff ($unroundedArray)
    {
        $this->baseArray = $unroundedArray;
        $this->surplusArray = [];
        $this->roundedArray = [];
        $this->toDistribute = 0;

        foreach ($this->baseArray as $value) {
            $this->roundDown($value);
        }

        asort($this->surplusArray);
        while (abs(($this->toDistribute - $this->roundByValue) / $this->roundByValue) < 0.00001) {
            $keyHighestValue = array_search(end($this->surplusArray), $this->surplusArray);
            $this->roundedArray[$keyHighestValue] += $this->roundByValue;
            unset($this->surplusArray[$keyHighestValue]);
            $this->toDistribute -= $this->roundByValue;
        }

        return $this->roundedArray;
    }

    /**
     *  Rounds down the value to the nearest $roundByValue
     *
     *  @param float $value
     */
    private function roundDown($value)
    {
        $surplus = fmod($value, $this->roundByValue);
        $this->toDistribute += $surplus;
        array_push($this->surplusArray, $surplus);
        array_push($this->roundedArray, $value - $surplus);
    }
}
