<?php
/**
 * Created by Roel van Endhoven.
 * User: Roel van Endhoven
 * Date: 8-12-16
 * Time: 12:02.
 */

namespace App\Util;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface RepositoryInterface
 * Repositories must define the following methods to alter models.
 */
interface RepositoryInterface
{
    /**
     * @param $id
     *
     * @return Model
     */
    public function getById($id);

    /**
     * @return Collection|Model[]
     */
    public function getAll();

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes);

    /**
     * @param $ids int|array
     *
     * @return int count of deleted rows
     */
    public function delete($ids);

    /*
        * @param $ids The id of the user to update
        * @return Model
        */
    // public function update($ids);
}//end interface
