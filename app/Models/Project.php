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
                           'project_contact_id'
                          ];

    /**
     * A optional contact which refers to a User. (or collection if called without parentheces).
     *
     * @return Elequent Relation
     */
    public function contact()
    {
        return $this->hasOne(User::class, 'project_contact_id');
    }

    /**
     * Many to many elequent relation with students. (or collection if called without parentheces).
     *
     * @return Elequent Relation
     */
    public function students()
    {
        return $this->belongsToMany(
            Student::class,
            'project_student',
            'project_id',
            'student_id'
        );
    }

    /**
     * Many to many elequent relation with competencies. (or collection if called without parentheces).
     *
     * @return Elequent Relation
     */
    public function competencies()
    {
        return $this->belongsToMany(
            Competency::class,
            'project_competency',
            'project_id',
            'competency_id'
        );
    }
}
