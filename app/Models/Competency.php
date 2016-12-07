<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competency extends Model
{
    protected $fillable = [
        'name', 'abbreviation', 'description', 'EC-value', 'CU-code'
    ];
}
