<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Student extends Model
{
    /**
     * Database table which this model refers to.
     *
     * @var string
     */
    protected $table = 'students';

    /**
     * Mass fillable fields.
     *
     * @var array
     */
    protected $fillable = [
                           'name',
                           'student_code',
                           'date_of_birth',
                           'starting_date',
                           'gender',
                          ];

    /**
     * Hidden fields (we have noting to hide).
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Optional Student link with a User.
     *
     * @return Elequent Relation
     */
    public function user()
    {
        // business rules limit this relation to 0 or 1.
        return $this->hasMany('App\Models\User');
    }

//end user()

    /**
     * Many to many elequent relation with projects. (or collection if called without parentheces).
     *
     * @return Relation
     */
    public function projects()
    {
        return $this->belongsToMany('App\Models\Project', 'project_student', 'student_id', 'project_id');
    }

//end projects()

    /**
     * Many to many elequent relation with competencies. (or collection if called without parentheces).
     *
     * @return Relation
     */
    public function competencies()
    {
        return $this->belongsToMany('App\Models\Competency', 'student_competency', 'student_id', 'competency_id')->withPivot('status');
    }

//end competencies()
}//end class
