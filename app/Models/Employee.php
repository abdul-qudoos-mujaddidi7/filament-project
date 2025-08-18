<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'adress',
        'birth_date',
        'hire_date',
        'deparmtment_id',
        'state_id',
        "city_id",
        "country_id"
    ];

    public function deparmtment()
    {
        return $this->belongsTo(Deparmtment::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
        // Defines a relationship with the Team model.
    }
}
