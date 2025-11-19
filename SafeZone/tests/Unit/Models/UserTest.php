<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Alert;
use App\Models\Report;
use App\Models\Address;
use App\Models\Rescue;
use App\Models\CustomDatabaseNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_has_fillable_attributes()
    {
        $fillable = ['name', 'email', 'password', 'role', 'phone'];

        $user = new User();
        
        $this->assertEquals($fillable, $user->getFillable());
    }

    /** @test */
    public function user_hides_password_and_remember_token()
    {
        $user = User::factory()->create(['password' => 'secret123']);

        $this->assertArrayNotHasKey('password', $user->toArray());
        $this->assertArrayNotHasKey('remember_token', $user->toArray());
    }

    /** @test */
    public function user_casts_email_verified_at_to_datetime()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $user->email_verified_at);
    }

    /** @test */
    public function user_hashes_password()
    {
        $user = User::factory()->create(['password' => 'plaintext123']);

        $this->assertNotEquals('plaintext123', $user->password);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('plaintext123', $user->password));
    }

    /** @test */
    public function user_has_many_alerts()
    {
        $user = User::factory()->create();
        Alert::factory()->count(3)->create(['created_by' => $user->id]);

        $this->assertEquals(3, $user->alerts->count());
        $this->assertInstanceOf(Alert::class, $user->alerts->first());
    }

    /** @test */
    public function user_has_many_reports()
    {
        $user = User::factory()->create();
        Report::factory()->count(2)->create(['user_id' => $user->id]);

        $this->assertEquals(2, $user->reports->count());
        $this->assertInstanceOf(Report::class, $user->reports->first());
    }

    /** @test */
    public function user_has_custom_notifications_relation()
    {
        $user = User::factory()->create();
        
        $user->notifications()->create([
            'id' => \Illuminate\Support\Str::uuid(),
            'type' => 'App\Notifications\AlertCreatedNotification',
            'data' => ['alert_id' => 1],
        ]);

        $this->assertInstanceOf(CustomDatabaseNotification::class, $user->notifications->first());
        $this->assertEquals(1, $user->notifications->count());
    }

    /** @test */
    public function user_has_many_addresses()
    {
        $user = User::factory()->create();
        
        $user->addresses()->create([
            'address_line' => '123 Test St',
            'city' => 'Hanoi',
            'latitude' => 21.0285,
            'longitude' => 105.8542,
        ]);

        $this->assertEquals(1, $user->addresses->count());
        $this->assertInstanceOf(Address::class, $user->addresses->first());
    }

    /** @test */
    public function user_has_many_rescues()
    {
        $user = User::factory()->create();
        Rescue::factory()->count(2)->create(['user_id' => $user->id]);

        $this->assertEquals(2, $user->rescues->count());
        $this->assertInstanceOf(Rescue::class, $user->rescues->first());
    }

    /** @test */
    public function user_routes_notification_for_vonage_correctly()
    {
        $user = User::factory()->create(['phone' => '0374169035']);

        $result = $user->routeNotificationForVonage(null);

        $this->assertEquals('+84374169035', $result);
    }

    /** @test */
    public function user_handles_phone_with_plus_84_prefix()
    {
        $user = User::factory()->create(['phone' => '+84374169035']);

        $result = $user->routeNotificationForVonage(null);

        $this->assertEquals('+84374169035', $result);
    }

    /** @test */
    public function user_handles_phone_with_84_prefix()
    {
        $user = User::factory()->create(['phone' => '84374169035']);

        $result = $user->routeNotificationForVonage(null);

        $this->assertEquals('+84374169035', $result);
    }

    /** @test */
    public function user_returns_null_for_vonage_when_no_phone()
    {
        $user = User::factory()->create(['phone' => null]);

        $result = $user->routeNotificationForVonage(null);

        $this->assertNull($result);
    }

    /** @test */
    public function user_can_be_admin()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->assertEquals('admin', $admin->role);
    }

    /** @test */
    public function user_can_be_regular_user()
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->assertEquals('user', $user->role);
    }
}
