<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competency extends Model
{

    /**
     * Mass fillable fields
     */
    protected $fillable = [
        'name', 'abbreviation', 'description', 'ec_value', 'cu_code'
    ];

    /**
     * Many to many elequent relation with students. (or collection if called without parentheces)
     *
     * @return Elequent Relation
     */
    public function students()
    {
        return $this->belongsToMany('App\Models\Student', 'student_competency', 'competency_id', 'student_id');
    }

    /**
     * Many to many elequent relation with students. (or collection if called without parentheces)
     *
     * @return Elequent Relation
     */
    public function projects()
    {
        return $this->belongsToMany('App\Models\Project', 'project_competency', 'competency_id', 'project_id');
    }
}
