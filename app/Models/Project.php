<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $fillable = [
        'name', 'projectnumber', 'description'
    ];

    public function contact()
    {
        return $this->hasOne('App\Models\User');
    }

    public function students()
    {
        return $this->belongsToMany('App\Models\Student', 'project_student', 'project_id', 'student_id');
    }

    public function competencies()
    {
        return $this->belongsToMany('App\Models\Competency', 'project_competency', 'project_id', 'competency_id');
    }
}
