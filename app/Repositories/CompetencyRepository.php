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
     * @param $id
     * @return Competency
     */
    public function getById($id)
    {
        return Competency::findOrFail($id);
    }

    /**
     * @return Collection|Competency[]
     */
    public function getAll()
    {
        return Competency::get();
    }

    /**
     * @param array $attributes
     * @return Competency
     */
    public function create(array $attributes)
    {
        return Competency::create($attributes);
    }

    /**
     * @param array|int $ids
     * @return mixed
     */
    public function delete($ids)
    {
        return Competency::destroy($ids);
    }


}