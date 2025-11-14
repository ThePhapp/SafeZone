<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification;

class CustomDatabaseNotification extends DatabaseNotification
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'laravel_notifications';
}
