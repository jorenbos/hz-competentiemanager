<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competency extends Model
{
    const STATUS_TODO = 0;
    const STATUS_DOING = 1;
    const STATUS_DONE = 2;
    const STATUS_HALF_DOING = 3;
    const STATUS_HALF_DONE = 4;
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
            self::class,
            'competencies_prerequisites',
            'competency_id',
            'competency_prerequisite_id'
        );
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
            'student_competency',
            'competency_id',
            'student_id'
        );
    }

    /**
     * Many to many elequent relation with students. (or collection if called without parentheces).
     *
     * @return Elequent Relation
     */
    public function projects()
    {
        return $this->belongsToMany(
            Project::class,
            'project_competency',
            'competency_id',
            'project_id'
        );
    }

    /**
     * Many to many elequent relation with slots. (or collection if called without parentheces).
     *
     * @return Relation
     */
    public function slots()
    {
        return $this->belongsToMany(
            Slot::class,
            'slots_competencies',
            'competency_id',
            'slot_id'
        );
    }

    /**
     * Many to many elequent relation with slots. (or collection if called without parentheces).
     *
     * @return Relation
     */
    public function sequentiality()
    {
        return $this->belongsToMany(
            self::class,
            'competencies_prerequisites',
            'competency_id',
            'competency_prerequisite_id')
            ->withPivot('rule', 'amount_required');
    }
}
