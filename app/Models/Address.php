<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    protected $fillable = [
        'address_line',
        'district',
        'city',
        'province',
        'country',
        'postal_code',
        'google_place_id',
        'formatted_address',
        'latitude',
        'longitude',
    ];

    public function addressable()
    {
        return $this->morphTo();
    }
}
