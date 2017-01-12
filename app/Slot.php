<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    $fillable = [
    	'phase'
    ];

    /**
     * Many to many elequent relation with competencies. (or collection if called without parentheces)
     *
     * @return Relation
     */
    public function compencies()
    {
    	$this->belongsToMany('App\Models\Competency', 'slots_competencies', 'slot_id', 'competency_id');
    }
}
