<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'latitude',
        'longitude',
        'capacity',
        'type',
        'status',
        'contact_phone',
        'contact_email',
        'facilities',
        'image_path',
    ];

    protected $casts = [
        'facilities' => 'array',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];
}
