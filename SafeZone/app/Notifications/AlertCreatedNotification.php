<?php

namespace App\Notifications;

use App\Models\Alert;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;
use App\Channels\CustomDatabaseChannel;
use App\Channels\VonageSmsChannel;


class AlertCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Alert $alert)
    {
        // Ensure relation is available when queued
        $this->alert->loadMissing('address');
    }

    public function via(object $notifiable): array
    {
        // Always store in DB + send email; add SMS if enabled and phone exists
        $channels = [CustomDatabaseChannel::class, 'mail'];
        
        if (config('services.sms.enabled') && !empty($notifiable->phone)) {
            $channels[] = VonageSmsChannel::class;
        }
        
        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $alert = $this->alert;
        $title = $alert->title ?? 'New Alert';
        $type = ucfirst($alert->type ?? 'event');
        $severity = strtoupper($alert->severity ?? 'info');
        $addressLine = optional($alert->address)->address_line;

        $url = url(route('disaster-monitor'));

        $mail = (new MailMessage)
            ->subject("[SafeZone] {$severity} {$type} alert: {$title}")
            ->greeting('Hello,')
            ->line($title)
            ->line("Type: {$type}")
            ->line("Severity: {$severity}");

        if ($addressLine) {
            $mail->line("Location: {$addressLine}");
        }

        if (!empty($alert->description)) {
            $mail->line('Description: ' . strip_tags((string) $alert->description));
        }

        $mail->action('Open Disaster Monitor', $url)
             ->line('Stay safe and follow instructions from authorities.');

        return $mail;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'alert_id' => $this->alert->id,
            'type' => $this->alert->type,
            'severity' => $this->alert->severity,
            'title' => $this->alert->title,
        ];
    }

    public function toVonage(object $notifiable): VonageMessage
    {
        $alert = $this->alert;
        $type = strtoupper((string) $alert->type);
        $sev = strtoupper((string) $alert->severity);
        $title = (string) ($alert->title ?? 'Alert');
        $loc = optional($alert->address)->city ?? optional($alert->address)->province ?? '';

        $summary = trim("[SafeZone] {$sev} {$type}: {$title}");
        if ($loc !== '') {
            $summary .= " @ {$loc}";
        }

        // Keep SMS short; include quick URL if available
        $url = url(route('disaster-monitor'));
        $text = mb_strimwidth($summary, 0, 140, '…') . " " . $url;

        // Log SMS attempt for debugging
        \Log::info('Sending SMS via Vonage', [
            'to' => $notifiable->routeNotificationForVonage($this),
            'from' => config('services.vonage.sms_from'),
            'message' => $text,
            'vonage_key' => config('services.vonage.key') ? 'SET' : 'MISSING',
        ]);

        return (new VonageMessage)
            ->content($text);
    }
}
