<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    /**
     * Mass fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'phase',
    ];

    /**
     * Many to many elequent relation with slots. (or collection if called without parentheces).
     *
     * @return Relation
     */
    public function competencies()
    {
        return $this->belongsToMany(
            Competency::class,
            'slots_competencies',
            'slot_id',
            'competency_id'
        );
    }
}
