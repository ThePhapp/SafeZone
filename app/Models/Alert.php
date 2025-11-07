<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'type',
        'severity',
        'radius',
        'issued_at',
        'created_by',
    ];

    protected $casts = [
        'type' => 'string',
        'severity' => 'string',
    ];


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }
    

}
