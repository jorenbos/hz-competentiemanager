<?php
/**
 * Created Roel van Endhoven
 * User: Roel van Endhoven
 * Date: 8-12-16
 * Time: 11:52
 */

namespace App\Repositories;

use App\Models\User;
use App\Util\The;
use Illuminate\Database\Eloquent\Model;
use Validator;
use App\Util\RepositoryInterface;

class UserRepository implements RepositoryInterface
{

    /**
     * @param $id
     * @return User
     */
    public function getById($id)
    {
        return User::findOrFail($id);
    }

    /**
     * Returns all instances of User in the database
     *
     * @return \Illuminate\Database\Eloquent\Collection|User[]
     */
    public function getAll()
    {
        return User::orderBy('name', 'asc')->get();
    }

    /**
     * @param array $attributes The attributes to assign to the model
     * @return User
     */
    public function create(array $attributes)
    {
        return User::create($attributes);
    }

    /**
     * @param $id
     * @return int the amount
     */
    public function delete($id)
    {
        return User::destroy($id);
    }

    /**
     * @param $ids
     * @return mixed
     */
    public function update($ids)
    {

    }


}
