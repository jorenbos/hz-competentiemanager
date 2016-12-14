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
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return Project::findOrFail($id);
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return Project::get();
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return Project::create($attributes);
    }

    /**
     * @param array|int $ids
     * @return mixed
     */
    public function delete($ids)
    {
        return Project::destroy($ids);
    }


}