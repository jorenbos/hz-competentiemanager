<?php

namespace App\Competencies\Filters;

use App\Util\Constants;

class ApplicabilityFilter
{
    public static function filterApplicability($competencies)
    {
        $returnCompetencies = collect();
        foreach ($competencies as $competency) {
            $isAllowed = true;
            $ruleSequentialComboRequired = 0;
            $ruleSequentialComboCounter = 0;

            foreach ($competency->sequentiality as $sequentialCompetency) {
                if ($sequentialCompetency->pivot->rule === Constants::RULE_TYPE_SEQUENTIAL_REQUIRED
                    && $competencies->contains('id', $sequentialCompetency->id)
                ) {
                    $isAllowed = false;
                    break;
                } elseif ($sequentialCompetency->pivot->rule === Constants::RULE_TYPE_SEQUENTIAL_COMBO) {
                    if ($ruleSequentialComboRequired === 0) {
                        $ruleSequentialComboRequired = $sequentialCompetency->pivot->amount_required;
                    }
                    if (!$competencies->contains('id', $sequentialCompetency->id)) {
                        $ruleSequentialComboCounter++;
                    }
                }
            }

            if ($ruleSequentialComboCounter < $ruleSequentialComboRequired) {
                $isAllowed = false;
            }

            if ($isAllowed) {
                $returnCompetencies->push($competency);
            }
        }

        return $returnCompetencies;
    }
}
