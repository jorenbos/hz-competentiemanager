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
}
