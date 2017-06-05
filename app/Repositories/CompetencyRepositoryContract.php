<?php

namespace App\Repositories;

use Rinvex\Repository\Contracts\CacheableContract;
use Rinvex\Repository\Contracts\RepositoryContract;

interface CompetencyRepositoryContract extends RepositoryContract, CacheableContract
{
    /**
     * Filters competencies on whether or not they are allowed to be picked by the Algorithm.
     * @return Collection[]
     */
    public function findAllowedForAlgorithm();
}
