<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Alert;
use App\Models\Report;
use App\Models\CustomDatabaseNotification;
use App\Models\Address;
use App\Models\Rescue;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class, 'created_by');
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function customNotifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Override Laravel's notifications() to use custom table.
     */
    public function notifications()
    {
        return $this->morphMany(CustomDatabaseNotification::class, 'notifiable')
                    ->orderBy('created_at', 'desc');
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function rescues()
    {
        return $this->hasMany(Rescue::class);
    }

    public function routeNotificationForVonage($notification)
    {
        if (empty($this->phone)) {
            return null;
        }
        
        // Convert Vietnamese phone format to E.164
        // 0374169035 -> +84374169035
        $phone = trim($this->phone);
        
        if (str_starts_with($phone, '0')) {
            return '+84' . substr($phone, 1);
        }
        
        if (str_starts_with($phone, '+84')) {
            return $phone;
        }
        
        if (str_starts_with($phone, '84')) {
            return '+' . $phone;
        }
        
        // Default: assume it's already valid or add +84
        return '+84' . ltrim($phone, '+');
    }
    
}
