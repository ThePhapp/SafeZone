<?php

namespace Tests\Unit\Notifications;

use App\Models\Alert;
use App\Models\User;
use App\Notifications\AlertCreatedNotification;
use App\Channels\CustomDatabaseChannel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class AlertCreatedNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected Alert $alert;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'phone' => '0374169035',
        ]);

        $this->alert = Alert::factory()->create([
            'title' => 'Test Alert',
            'type' => 'flood',
            'severity' => 'high',
            'description' => 'Test description',
        ]);

        $this->alert->address()->create([
            'address_line' => '123 Main St',
            'city' => 'Hanoi',
            'province' => 'Hanoi',
            'latitude' => 21.0285,
            'longitude' => 105.8542,
        ]);
    }

    /** @test */
    public function notification_implements_should_queue()
    {
        $notification = new AlertCreatedNotification($this->alert);

        $this->assertInstanceOf(\Illuminate\Contracts\Queue\ShouldQueue::class, $notification);
    }

    /** @test */
    public function notification_loads_address_relation()
    {
        $alert = Alert::factory()->create();
        $alert->address()->create([
            'address_line' => 'Test Address',
            'latitude' => 21.0285,
            'longitude' => 105.8542,
        ]);

        $notification = new AlertCreatedNotification($alert);

        $this->assertTrue($alert->relationLoaded('address'));
    }

    /** @test */
    public function notification_via_includes_custom_database_and_mail()
    {
        Config::set('services.sms.enabled', false);

        $notification = new AlertCreatedNotification($this->alert);
        $channels = $notification->via($this->user);

        $this->assertContains(CustomDatabaseChannel::class, $channels);
        $this->assertContains('mail', $channels);
    }

    /** @test */
    public function notification_via_includes_sms_when_enabled_and_phone_exists()
    {
        Config::set('services.sms.enabled', true);

        $notification = new AlertCreatedNotification($this->alert);
        $channels = $notification->via($this->user);

        $this->assertContains(CustomDatabaseChannel::class, $channels);
        $this->assertContains('mail', $channels);
        $this->assertContains(\App\Channels\VonageSmsChannel::class, $channels);
    }

    /** @test */
    public function notification_via_excludes_sms_when_phone_missing()
    {
        Config::set('services.sms.enabled', true);
        $userWithoutPhone = User::factory()->create(['phone' => null]);

        $notification = new AlertCreatedNotification($this->alert);
        $channels = $notification->via($userWithoutPhone);

        $this->assertNotContains(\App\Channels\VonageSmsChannel::class, $channels);
    }

    /** @test */
    public function to_mail_returns_mail_message()
    {
        $notification = new AlertCreatedNotification($this->alert);
        $mailMessage = $notification->toMail($this->user);

        $this->assertInstanceOf(\Illuminate\Notifications\Messages\MailMessage::class, $mailMessage);
        $this->assertStringContainsString('[SafeZone]', $mailMessage->subject);
        $this->assertStringContainsString('HIGH', $mailMessage->subject);
        $this->assertStringContainsString('Test Alert', $mailMessage->subject);
    }

    /** @test */
    public function to_mail_includes_alert_details()
    {
        $notification = new AlertCreatedNotification($this->alert);
        $mailMessage = $notification->toMail($this->user);

        $this->assertStringContainsString('Test Alert', $mailMessage->subject);
        $this->assertStringContainsString('flood', strtolower($mailMessage->subject));
    }

    /** @test */
    public function to_mail_includes_location_when_available()
    {
        $notification = new AlertCreatedNotification($this->alert);
        $mailMessage = $notification->toMail($this->user);

        // Check if location is mentioned in lines
        $lines = collect($mailMessage->introLines);
        $hasLocation = $lines->contains(function ($line) {
            return str_contains($line, 'Location:');
        });

        $this->assertTrue($hasLocation);
    }

    /** @test */
    public function to_mail_includes_description_when_available()
    {
        $notification = new AlertCreatedNotification($this->alert);
        $mailMessage = $notification->toMail($this->user);

        $lines = collect($mailMessage->introLines);
        $hasDescription = $lines->contains(function ($line) {
            return str_contains($line, 'Description:');
        });

        $this->assertTrue($hasDescription);
    }

    /** @test */
    public function to_array_returns_alert_data()
    {
        $notification = new AlertCreatedNotification($this->alert);
        $array = $notification->toArray($this->user);

        $this->assertArrayHasKey('alert_id', $array);
        $this->assertArrayHasKey('type', $array);
        $this->assertArrayHasKey('severity', $array);
        $this->assertArrayHasKey('title', $array);
        $this->assertEquals($this->alert->id, $array['alert_id']);
        $this->assertEquals('flood', $array['type']);
        $this->assertEquals('high', $array['severity']);
    }

    /** @test */
    public function to_vonage_returns_vonage_message()
    {
        $notification = new AlertCreatedNotification($this->alert);
        $vonageMessage = $notification->toVonage($this->user);

        $this->assertInstanceOf(\Illuminate\Notifications\Messages\VonageMessage::class, $vonageMessage);
    }

    /** @test */
    public function to_vonage_includes_severity_and_type()
    {
        $notification = new AlertCreatedNotification($this->alert);
        $vonageMessage = $notification->toVonage($this->user);

        $content = $vonageMessage->content;

        $this->assertStringContainsString('HIGH', $content);
        $this->assertStringContainsString('FLOOD', $content);
    }

    /** @test */
    public function to_vonage_includes_location_when_available()
    {
        $notification = new AlertCreatedNotification($this->alert);
        $vonageMessage = $notification->toVonage($this->user);

        $content = $vonageMessage->content;

        $this->assertStringContainsString('Hanoi', $content);
    }

    /** @test */
    public function to_vonage_keeps_message_short()
    {
        $longAlert = Alert::factory()->create([
            'title' => str_repeat('A very long alert title ', 20),
            'type' => 'flood',
            'severity' => 'critical',
        ]);
        $longAlert->address()->create([
            'city' => 'Hanoi',
            'latitude' => 21.0285,
            'longitude' => 105.8542,
        ]);

        $notification = new AlertCreatedNotification($longAlert);
        $vonageMessage = $notification->toVonage($this->user);

        // SMS should be truncated with ellipsis + URL
        $this->assertLessThan(200, strlen($vonageMessage->content));
        $this->assertStringContainsString('http', $vonageMessage->content);
    }

    /** @test */
    public function notification_handles_missing_address_gracefully()
    {
        $alertWithoutAddress = Alert::factory()->create([
            'title' => 'No Address Alert',
            'type' => 'fire',
            'severity' => 'medium',
        ]);

        $notification = new AlertCreatedNotification($alertWithoutAddress);
        $mailMessage = $notification->toMail($this->user);

        $this->assertInstanceOf(\Illuminate\Notifications\Messages\MailMessage::class, $mailMessage);
    }

    /** @test */
    public function notification_handles_missing_description()
    {
        $alert = Alert::factory()->create([
            'title' => 'No Description',
            'description' => null,
            'type' => 'storm',
            'severity' => 'low',
        ]);

        $notification = new AlertCreatedNotification($alert);
        $mailMessage = $notification->toMail($this->user);

        $this->assertInstanceOf(\Illuminate\Notifications\Messages\MailMessage::class, $mailMessage);
    }
}
