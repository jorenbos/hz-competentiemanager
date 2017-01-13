<?php
/**
 * Created by Roel van Endhoven.
 * User: Roel van Endhoven
 * Date: 8-12-16
 * Time: 12:23
 */

namespace App\Repositories;


use App\Models\Competency;
use App\Util\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CompetencyRepository implements RepositoryInterface
{
    /**
     * Returns competency with given id from database
     *
     * @param  $id
     * @return mixed
     */
    public function getById($id)
    {
        return Competency::findOrFail($id);
    }

    /**
     * Returns all competencies in the database
     *
     * @return Collection|Competency[]
     */
    public function getAll()
    {
        return Competency::get();
    }

    /**
     * Creates a new competency and stores it in the database
     *
     * @param  array $attributes
     * @return Competency
     */
    public function create(array $attributes)
    {
        return Competency::create($attributes);
    }

    /**
     * Removes competencies with given ids from the database
     *
     * @param  array|int $ids
     * @return mixed
     */
    public function delete($ids)
    {
        return Competency::destroy($ids);
    }

    /**
     * Updates given fields of the repository with the given id
     *
     * @param  array
     * @param  int   $id
     * @return Competency
     */
    public function update($data, $id)
    {
        return Competency::findOrFail($id)->update($data);
    }


}
