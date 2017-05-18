<?php

namespace App\Repositories;

use App\Models\Project;
use App\Util\AbstractRepository;

class ProjectRepository extends AbstractRepository
{

    public function __construct(Project $projects)
    {
        parent::__construct($projects);
    }

}
