<?php

namespace Tests\Feature\Admin;

use App\Models\Alert;
use App\Models\User;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AlertCreatedNotification;
use Tests\TestCase;

class AlertControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $admin;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@test.com',
        ]);

        // Create regular user with address near alert location
        $this->user = User::factory()->create([
            'role' => 'user',
            'email' => 'user@test.com',
        ]);

        // Add address to user within 1000m of test location
        $this->user->addresses()->create([
            'address_line' => '123 Test Street',
            'city' => 'Hanoi',
            'country' => 'Vietnam',
            'latitude' => 21.0285, // Near alert test location
            'longitude' => 105.8542,
        ]);
    }

    /** @test */
    public function admin_can_view_alerts_index()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.alerts.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.alerts.index');
        $response->assertViewHas('alerts');
    }

    /** @test */
    public function admin_can_filter_alerts_by_status()
    {
        $this->actingAs($this->admin);

        // Create alerts with different statuses
        Alert::factory()->create(['status' => 'active']);
        Alert::factory()->create(['status' => 'resolved']);

        $response = $this->get(route('admin.alerts.index', ['status' => 'active']));

        $response->assertStatus(200);
        $response->assertViewHas('alerts');
    }

    /** @test */
    public function admin_can_search_alerts()
    {
        $this->actingAs($this->admin);

        Alert::factory()->create(['title' => 'Flood Warning']);
        Alert::factory()->create(['title' => 'Fire Alert']);

        $response = $this->get(route('admin.alerts.index', ['search' => 'Flood']));

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_view_create_alert_form()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.alerts.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.alerts.create');
    }

    /** @test */
    public function admin_can_create_alert_with_valid_data()
    {
        Notification::fake();
        Http::fake([
            '*' => Http::response(['success' => true], 200),
        ]);

        $this->actingAs($this->admin);

        $alertData = [
            'title' => 'Test Flood Alert',
            'description' => 'Heavy rain expected',
            'type' => 'flood',
            'severity' => 'high',
            'radius' => 5000,
            'address_line' => '456 Main Street',
            'district' => 'Ba Dinh',
            'city' => 'Hanoi',
            'province' => 'Hanoi',
            'country' => 'Vietnam',
            'postal_code' => '100000',
            'latitude' => 21.0285,
            'longitude' => 105.8542,
        ];

        $response = $this->post(route('admin.alerts.store'), $alertData);

        $response->assertRedirect(route('admin.alerts.index'));
        $response->assertSessionHas('success', 'Alert created successfully.');

        $this->assertDatabaseHas('alerts', [
            'title' => 'Test Flood Alert',
            'type' => 'flood',
            'severity' => 'high',
            'created_by' => $this->admin->id,
        ]);

        $this->assertDatabaseHas('addresses', [
            'address_line' => '456 Main Street',
            'city' => 'Hanoi',
            'latitude' => 21.0285,
        ]);

        // Verify notification was sent to users in range
        Notification::assertSentTo($this->user, AlertCreatedNotification::class);
    }

    /** @test */
    public function alert_creation_validates_required_fields()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.alerts.store'), []);

        $response->assertSessionHasErrors(['title', 'address_line', 'latitude', 'longitude']);
    }

    /** @test */
    public function alert_creation_validates_latitude_is_numeric()
    {
        $this->actingAs($this->admin);

        $alertData = [
            'title' => 'Test Alert',
            'address_line' => '123 Test St',
            'latitude' => 'invalid',
            'longitude' => 105.8542,
        ];

        $response = $this->post(route('admin.alerts.store'), $alertData);

        $response->assertSessionHasErrors(['latitude']);
    }

    /** @test */
    public function alert_creation_handles_image_upload()
    {
        Storage::fake('public');
        Http::fake();
        Notification::fake();

        $this->actingAs($this->admin);

        $file = UploadedFile::fake()->image('alert.jpg');

        $alertData = [
            'title' => 'Test Alert with Image',
            'description' => 'Test description',
            'type' => 'fire',
            'severity' => 'critical',
            'radius' => 3000,
            'address_line' => '789 Test Ave',
            'latitude' => 21.0285,
            'longitude' => 105.8542,
            'image' => $file,
        ];

        $response = $this->post(route('admin.alerts.store'), $alertData);

        $response->assertRedirect(route('admin.alerts.index'));

        $alert = Alert::where('title', 'Test Alert with Image')->first();
        $this->assertNotNull($alert);
        $this->assertNotEquals('base.png', $alert->image_path);
    }

    /** @test */
    public function alert_creation_uses_default_image_when_no_upload()
    {
        Http::fake();
        Notification::fake();

        $this->actingAs($this->admin);

        $alertData = [
            'title' => 'Alert without Image',
            'type' => 'storm',
            'severity' => 'medium',
            'address_line' => '123 Test St',
            'latitude' => 21.0285,
            'longitude' => 105.8542,
        ];

        $response = $this->post(route('admin.alerts.store'), $alertData);

        $alert = Alert::where('title', 'Alert without Image')->first();
        $this->assertEquals('base.png', $alert->image_path);
    }

    /** @test */
    public function alert_creation_broadcasts_to_realtime_server()
    {
        Http::fake([
            '*/new-alert' => Http::response(['success' => true], 200),
        ]);
        Notification::fake();

        $this->actingAs($this->admin);

        $alertData = [
            'title' => 'Broadcast Test Alert',
            'type' => 'earthquake',
            'severity' => 'critical',
            'address_line' => '123 Test St',
            'latitude' => 21.0285,
            'longitude' => 105.8542,
        ];

        $response = $this->post(route('admin.alerts.store'), $alertData);

        Http::assertSent(function ($request) {
            return str_contains($request->url(), '/new-alert');
        });
    }

    /** @test */
    public function alert_creation_continues_on_broadcast_failure()
    {
        Http::fake([
            '*' => Http::response([], 500),
        ]);
        Notification::fake();

        $this->actingAs($this->admin);

        $alertData = [
            'title' => 'Alert with Failed Broadcast',
            'type' => 'flood',
            'severity' => 'low',
            'address_line' => '123 Test St',
            'latitude' => 21.0285,
            'longitude' => 105.8542,
        ];

        $response = $this->post(route('admin.alerts.store'), $alertData);

        $response->assertRedirect(route('admin.alerts.index'));
        $this->assertDatabaseHas('alerts', [
            'title' => 'Alert with Failed Broadcast',
        ]);
    }

    /** @test */
    public function admin_can_view_alert_details()
    {
        $this->actingAs($this->admin);

        $alert = Alert::factory()->create();

        $response = $this->get(route('admin.alerts.show', $alert->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.alerts.show');
        $response->assertViewHas('alert');
    }

    /** @test */
    public function admin_can_view_edit_alert_form()
    {
        $this->actingAs($this->admin);

        $alert = Alert::factory()->create();

        $response = $this->get(route('admin.alerts.edit', $alert->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.alerts.edit');
        $response->assertViewHas('alert');
    }

    /** @test */
    public function admin_can_update_alert()
    {
        $this->actingAs($this->admin);

        $alert = Alert::factory()->create([
            'title' => 'Original Title',
        ]);

        $updateData = [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'type' => 'fire',
            'severity' => 'critical',
            'radius' => 10000,
            'address_line' => 'Updated Address',
            'latitude' => 21.0500,
            'longitude' => 105.8700,
        ];

        $response = $this->put(route('admin.alerts.update', $alert->id), $updateData);

        $response->assertRedirect(route('admin.alerts.index'));
        $response->assertSessionHas('success', 'Alert updated successfully.');

        $this->assertDatabaseHas('alerts', [
            'id' => $alert->id,
            'title' => 'Updated Title',
            'type' => 'fire',
        ]);
    }

    /** @test */
    public function admin_can_delete_alert()
    {
        $this->actingAs($this->admin);

        $alert = Alert::factory()->create();
        $alertId = $alert->id;

        $response = $this->delete(route('admin.alerts.destroy', $alert->id));

        $response->assertRedirect(route('admin.alerts.index'));
        $response->assertSessionHas('success', 'Alert deleted successfully.');

        $this->assertDatabaseMissing('alerts', ['id' => $alertId]);
    }

    /** @test */
    public function regular_user_cannot_access_admin_alerts()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $response = $this->get(route('admin.alerts.index'));

        // Assuming middleware redirects or returns 403
        $response->assertStatus(403);
    }

    /** @test */
    public function guest_cannot_access_admin_alerts()
    {
        $response = $this->get(route('admin.alerts.index'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function notifications_are_queued_for_users_in_radius()
    {
        Notification::fake();
        Http::fake();

        $this->actingAs($this->admin);

        // Create multiple users with addresses in range
        $users = User::factory()->count(3)->create(['role' => 'user']);
        foreach ($users as $user) {
            $user->addresses()->create([
                'address_line' => '123 Test St',
                'city' => 'Hanoi',
                'latitude' => 21.0285,
                'longitude' => 105.8542,
            ]);
        }

        $alertData = [
            'title' => 'Mass Notification Test',
            'type' => 'flood',
            'severity' => 'high',
            'radius' => 5000,
            'address_line' => '456 Main St',
            'latitude' => 21.0285,
            'longitude' => 105.8542,
        ];

        $response = $this->post(route('admin.alerts.store'), $alertData);

        // Verify notifications sent to all users in range
        Notification::assertSentTo($users, AlertCreatedNotification::class);
    }
}
