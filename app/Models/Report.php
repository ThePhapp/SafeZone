<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //
    protected $fillable = [
        'user_id',
        'alert_id',
        'content',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function alert()
    {
        return $this->belongsTo(Alert::class);
    }
    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
