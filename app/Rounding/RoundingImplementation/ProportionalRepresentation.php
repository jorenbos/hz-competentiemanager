<?php

namespace App\Rounding\RoundingImplementation;

use App\Rounding\ComptencyDemandRoundingInterface;

class ProportionalRepresentation implements ComptencyDemandRoundingInterface
{
    /**
     * @var float
     */
    private $toDistribute;

    /**
     * Rounds off an array of numbers, using Proportional Representation.
     *
     * @param Array $unroundedArray | Array containing demand and ec value
     *
     * @return int[]
     */
    public function roundOff($unroundedArray)
    {

        $this->toDistribute = 0;

        $demandArray = array_map(array($this, "calcECDemand"), $unroundedArray);
        $demandSurplusArray = array_map(array($this, "calculateSurplus"),$demandArray);
        return $this->increaseHighest($demandSurplusArray);

    }

    /**
     * Caluclates the demand based on EC value of competency.
     *
     * @param Array $value
     *
     * @return Array
     */
    private function calcECDemand($value)
    {
        $value['demand'] = $value['demand'] * $value['ec_value'];
        return $value;
    }

    /**
     * Calculates the surplus and adds it to the to distribute.
     *
     * @param Array $value
     *
     * @return Array
     */
    private function calculateSurplus($value)
    {
        $value['surplus'] = fmod($value['demand'], $value['ec_value']);
        $this->toDistribute += $value['surplus'];
        $value['demand_absolute'] = $value['demand'];
        $value['demand'] = $value['demand'] - $value['surplus'];
        return $value;
    }

    private function increaseHighest($demandArray)
    {
        if ($this->toDistribute > 2.5 ) {

            $highestKey = $this->findHighestKey($demandArray);
            if ($this->toDistribute - $demandArray[$highestKey]['ec_value'] >= 0) {
                $demandArray[$highestKey]['demand'] +=1;
                $this->toDistribute -= $demandArray[$highestKey]['ec_value'];
            }
            $demandArray[$highestKey]['surplus'] = 0;
            return $this->increaseHighest($demandArray);
        }
        return $demandArray;

    }

    private function findHighestKey($array)
    {
        $max = 0;
        $founditem = null;
        foreach($array as $value) {
            if ($value['demand_absolute'] == 0) {
                continue;
            }
            $percent = $value['surplus'] / ($value['demand_absolute'] * $value['ec_value']);
            if ($percent < $max) {
                $max = $percent;
                $founditem = $value;
            }
        }

        return array_search($value, $array);
    }
}
