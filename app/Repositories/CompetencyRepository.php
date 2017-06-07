<?php

namespace App\Repositories;

use App\Models\Competency;
use App\Util\Constants;
use Illuminate\Database\Eloquent\Collection;
use Rinvex\Repository\Repositories\EloquentRepository;

class CompetencyRepository extends EloquentRepository implements CompetencyRepositoryContract
{
    protected $repositoryId = 'hz.competencies';
    protected $model = Competency::class;
    protected $relations = ['sequentiality'];
    
    /**
     * Filters competencies on whether or not they are allowed to be picked by the Algorithm.
     *
     * @return Collection[]
     */
    public function findAllowedForAlgorithm()
    {
        return $this->findWhere(['pickable_for_algorithm', '=', Constants::COMPETENCY_ALGORITHIM_ALLOWED_TRUE]);
    }

}
