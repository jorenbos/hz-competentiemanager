<?php

namespace App\Repositories;

use App\Models\Competency;
use App\Util\AbstractRepository;
use App\Util\Constants;
use Illuminate\Database\Eloquent\Collection;

class CompetencyRepository extends AbstractRepository
{
    /**
     * Constrcutor.
     */
    public function __construct(Competency $competencies)
    {
        parent::__construct($competencies);
    }

    /**
     * Filters competencies on whether or not they are allowed to be picked by the Algorithm.
     *
     * @param Competency |Collection[] (optional) $competencies
     *
     * @return Collection[]
     */
    public function filterAllowedForAlgorithm($competencies = null)
    {
        if ($competencies === null) {
            $competencies = $this->setColumns(['id', 'pickable_for_algorithm'])->getAll();
        }

        return $competencies->where('pickable_for_algorithm', Constants::COMPETENCY_ALGORITHIM_ALLOWED_TRUE);
    }
}
