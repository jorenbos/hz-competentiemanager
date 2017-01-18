<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * Mass fillable fields.
     *
     * @var array
     */
    protected $fillable = [
                           'name',
                           'projectnumber',
                           'description',
                          ];

    /**
     * A optional contact which refers to a User. (or collection if called without parentheces).
     *
     * @return Elequent Relation
     */
    public function contact()
    {
        return $this->hasOne('App\Models\User');
    }

//end contact()

    /**
     * Many to many elequent relation with students. (or collection if called without parentheces).
     *
     * @return Elequent Relation
     */
    public function students()
    {
        return $this->belongsToMany('App\Models\Student', 'project_student', 'project_id', 'student_id');
    }

//end students()

    /**
     * Many to many elequent relation with competencies. (or collection if called without parentheces).
     *
     * @return Elequent Relation
     */
    public function competencies()
    {
        return $this->belongsToMany('App\Models\Competency', 'project_competency', 'project_id', 'competency_id');
    }

//end competencies()
}//end class
