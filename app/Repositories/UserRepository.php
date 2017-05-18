<?php

namespace App\Repositories;

use App\Models\Student;
use App\Models\User;
use App\Util\AbstractRepository;

class UserRepository extends AbstractRepository
{


    public function __construct(User $users)
    {
        parent::__construct($users);
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

}
