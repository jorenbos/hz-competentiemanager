<?php
/**
 * Created by Roel van Endhoven.
 * User: Roel van Endhoven
 * Date: 8-12-16
 * Time: 12:22
 */

namespace App\Repositories;


use App\Models\Project;
use App\Util\RepositoryInterface;

class ProjectRepository implements RepositoryInterface
{
    /**
     * Returns project with given id from database
     *
     * @param  $id
     * @return Project
     */
    public function getById($id)
    {
        return Project::findOrFail($id);
    }

    /**
     * Returns all projects in the database
     *
     * @return Collection|Project d[]
     */
    public function getAll()
    {
        return Project::get();
    }

    /**
     * Creates a new Project and stores it in the database
     *
     * @param  array $attributes
     * @return Project
     */
    public function create(array $attributes)
    {
        return Project::create($attributes);
    }

    /**
     * Removes projects with given ids from the database
     *
     * @param  array|int $ids
     * @return mixed
     */
    public function delete($ids)
    {
        return Project::destroy($ids);
    }


}
