<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competency extends Model
{
    protected $fillable = [
        'name', 'abbreviation', 'description', 'ec_value', 'cu_code'
    ];

    public function students()
    {
        return $this->belongsToMany('App\Models\Student', 'student_competency', 'competency_id', 'student_id');
    }

    public function projects()
    {
        return $this->belongsToMany('App\Models\Project', 'project_competency', 'competency_id', 'project_id');
    }
}
