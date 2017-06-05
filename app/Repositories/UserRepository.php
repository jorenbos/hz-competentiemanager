<?php

namespace App\Repositories;

use App\Models\User;
use Rinvex\Repository\Repositories\EloquentRepository;

class UserRepository extends EloquentRepository implements UserRepositoryContract
{
    protected $repositoryId = 'hz.users';
    protected $model = User::class;
}
