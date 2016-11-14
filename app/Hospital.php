<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider_id', 'name', 'address', 'city',
        'state', 'zipcode', 'county', 'phone',
        'type', 'ownership', 'emergency_services',
        'human_address', 'latitude', 'longitude'
    ];
}
