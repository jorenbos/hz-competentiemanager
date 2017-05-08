<?php

namespace App\Repositories;

use App\Models\Project;
use App\Util\RepositoryInterface;

class ProjectRepository implements RepositoryInterface
{
    /**
     * @var Project
     */
    private $projects;

    public function __construct(Project $projects)
    {
        $this->projects = $projects;
    }
    //TODO: add update functionality.

    /**
     * Returns project with given id from database.
     *
     * @param  $id
     *
     * @return Project
     */
    public function getById($id)
    {
        return $this->projects->findOrFail($id);
    }

    /**
     * Returns all projects in the database.
     *
     * @return Collection|Project d[]
     */
    public function getAll()
    {
        return $this->projects->get();
    }

    /**
     * Creates a new Project and stores it in the database.
     *
     * @param array $attributes
     *
     * @return Project
     */
    public function create(array $attributes)
    {
        return $this->projects->create($attributes);
    }

    /**
     * Removes projects with given ids from the database.
     *
     * @param array|int $ids
     *
     * @return mixed
     */
    public function delete($ids)
    {
        return $this->projects->destroy($ids);
    }
}
