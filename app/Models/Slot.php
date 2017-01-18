<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    /**
     * Mass fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'phase'
    ];

    /**
     * Hidden fields (we have noting to hide)
     *
     * @var array
     */
    protected $hidden = [];
}
