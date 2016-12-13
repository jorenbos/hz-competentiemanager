<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCredentials extends Model
{

    protected $table = 'user_credentials';

    protected $fillable= [
        'name',
        'student_code',
        'date_of_birth',
        'starting_date',
        'gender'
    ];

    // We have nothing to hide
    protected $hidden = [];

}
