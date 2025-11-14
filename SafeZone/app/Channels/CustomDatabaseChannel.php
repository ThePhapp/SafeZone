<?php

namespace App\Channels;

use Illuminate\Notifications\Channels\DatabaseChannel;
use Illuminate\Notifications\Notification;
use App\Models\CustomDatabaseNotification;

class CustomDatabaseChannel extends DatabaseChannel
{
    /**
     * Build an array payload for the DatabaseNotification Model.
     */
    protected function buildPayload($notifiable, Notification $notification): array
    {
        return [
            'id' => $notification->id,
            'type' => get_class($notification),
            'data' => $this->getData($notifiable, $notification),
            'read_at' => null,
        ];
    }

    /**
     * Send the given notification.
     */
    public function send($notifiable, Notification $notification): CustomDatabaseNotification
    {
        return $notifiable->notifications()->create($this->buildPayload($notifiable, $notification));
    }
}
