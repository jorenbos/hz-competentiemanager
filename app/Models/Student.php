<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $table = 'students';

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
