<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //

    protected $fillable = [
        'name',
        'code',
    ];

    public function weatherData()
    {
        return $this->hasMany(WeatherData::class);
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
