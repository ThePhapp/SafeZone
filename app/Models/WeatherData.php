<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model
{
    //
    protected $fillable = [
        'location_id',
        'temperature',
        'humidity',
        'rainfall',
        'wind_speed',
        'pressure',
        'recorded_at',
    ];
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    
}
