<?php

namespace App\Repositories;

use App\Models\Project;
use Rinvex\Repository\Repositories\EloquentRepository;

class ProjectRepository extends EloquentRepository implements ProjectRepositoryContract
{
    protected $repositoryId = 'hz.projects';
    protected $model = Project::class;
}
