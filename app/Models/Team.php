<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

  public function members()
    {
        return $this->belongsToMany(User::class);
        // Defines a many-to-many relationship with the User model.
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
        // Defines a one-to-many relationship with the Employee model.
    }

    public function deparmtments()
    {
        return $this->hasMany(Deparmtment::class);
        // Defines a one-to-many relationship with the Deparmtment model.
    }
}
