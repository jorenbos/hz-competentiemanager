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

    public function user()
    {
        // business rules limit this relation to 0 or 1.
        return $this->hasMany('App\Models\User');
    }

}
