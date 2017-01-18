<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competency extends Model
{
    /**
     * Mass fillable fields.
     */
    protected $fillable = [
                           'name',
                           'abbreviation',
                           'description',
                           'ec_value',
                           'cu_code',
                          ];

    /**
     * Many to many elequent relation with students. (or collection if called without parentheces).
     *
     * @return Elequent Relation
     */
    public function prerequisiteCompetencies()
    {
        return $this->belongsToMany(
            'App\Models\Competency',
            'competencies_prerequisites',
            'competency_id',
            'competency_prerequisite_id'
        );
    }

//end prerequisiteCompetencies()

    /**
     * Many to many elequent relation with students. (or collection if called without parentheces).
     *
     * @return Elequent Relation
     */
    public function students()
    {
        return $this->belongsToMany('App\Models\Student', 'student_competency', 'competency_id', 'student_id');
    }

//end students()

    /**
     * Many to many elequent relation with students. (or collection if called without parentheces).
     *
     * @return Elequent Relation
     */
    public function projects()
    {
        return $this->belongsToMany('App\Models\Project', 'project_competency', 'competency_id', 'project_id');
    }

//end projects()

    /**
     * Many to many elequent relation with slots. (or collection if called without parentheces).
     *
     * @return Relation
     */
    public function slots()
    {
        $this->belongsToMany('App\Models\Slot', 'slots_competencies', 'competency_id', 'slot_id');
    }

//end slots()
}//end class
