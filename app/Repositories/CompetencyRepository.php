<?php
/**
 * Created by Roel van Endhoven.
 * User: Roel van Endhoven
 * Date: 8-12-16
 * Time: 12:23.
 */

namespace App\Repositories;

use App\Models\Competency;
use App\Util\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CompetencyRepository implements RepositoryInterface
{
    /**
     * Returns competency with given id from database.
     *
     * @param  $id
     *
     * @return mixed
     */
    public function getById($id)
    {
        return Competency::findOrFail($id);
    }

//end getById()

    /**
     * Returns all competencies in the database.
     *
     * @return Collection|Competency[]
     */
    public function getAll()
    {
        return Competency::get();
    }

//end getAll()

    /**
     * Creates a new competency and stores it in the database.
     *
     * @param array $attributes
     *
     * @return Competency
     */
    public function create(array $attributes)
    {
        return Competency::create($attributes);
    }

//end create()

    /**
     * Removes competencies with given ids from the database.
     *
     * @param int $ids
     *
     * @return mixed
     */
    public function delete($ids)
    {
        return Competency::destroy($ids);
    }

//end delete()

    /**
     * Updates given fields of the repository with the given id.
     *
     * @param  array
     * @param int $id
     *
     * @return Competency
     */
    public function update($data, $id)
    {
        $result = Competency::findOrFail($id)->update($data);
        Competency::findOrFail($id)->save();

        return $result;
    }

//end update()
}//end class
