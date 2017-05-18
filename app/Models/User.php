<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                           'name',
                           'email',
                           'password',
                          ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
                         'password',
                         'remember_token',
                        ];

    /**
     * Many to many elequent relation with competencies. (or collection if called without parentheces).
     *
     * @return Elequent Relation
     */
    public function competencies()
    {
        return $this->hasMany(Competency::class);
    }

    /**
     * If assigned to a project as contact, will return that relation.
     *
     * @return Elequent Relation
     */
    public function contactOfProject()
    {
        return $this->belongsTo(Project::class, 'project_contact_id');
    }

    /**
     * Optional link between a User and a Student.
     *
     * @return Elequent Relation
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
