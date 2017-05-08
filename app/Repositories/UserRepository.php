<?php

namespace App\Repositories;

use App\Models\Student;
use App\Models\User;
use App\Util\RepositoryInterface;

class UserRepository implements RepositoryInterface
{
    /**
     * @var User
     */
    private $users;

    public function __construct(User $users)
    {
        $this->users = $users;
    }

    //TODO: add update functionality.

    /**
     * Returns User with given id from database.
     *
     * @param  $id
     *
     * @return User
     */
    public function getById($id)
    {
        return $this->users->findOrFail($id);
    }

    /**
     * Returns all instances of User in the database.
     *
     * @return Collection|User[]
     */
    public function getAll()
    {
        return $this->users->orderBy('name', 'asc')->get();
    }

    /**
     * Returns instance of coupled student if possible.
     *
     * @return Collection|Student[]
     */
    public function getStudent($id)
    {
        return $this->users->find($id)->student;
    }

    /**
     * Creates a new competency and stores it in the database.
     *
     * @param array $attributes
     *
     * @return Competency
     */
    public function create(array $attributes)
    {
        return $this->users->create($attributes);
    }

    /**
     * Removes users with given ids from the database.
     *
     * @param array|int $ids
     *
     * @return mixed
     */
    public function delete($id)
    {
        return $this->users->destroy($id);
    }
}
