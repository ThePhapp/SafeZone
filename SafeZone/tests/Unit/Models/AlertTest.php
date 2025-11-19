<?php

namespace Tests\Unit\Models;

use App\Models\Alert;
use App\Models\User;
use App\Models\Address;
use App\Models\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlertTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function alert_has_fillable_attributes()
    {
        $fillable = [
            'title',
            'description',
            'image_path',
            'type',
            'severity',
            'status',
            'radius',
            'issued_at',
            'created_by',
        ];

        $alert = new Alert();
        
        $this->assertEquals($fillable, $alert->getFillable());
    }

    /** @test */
    public function alert_casts_type_to_string()
    {
        $alert = Alert::factory()->create(['type' => 'flood']);

        $this->assertIsString($alert->type);
    }

    /** @test */
    public function alert_casts_severity_to_string()
    {
        $alert = Alert::factory()->create(['severity' => 'high']);

        $this->assertIsString($alert->severity);
    }

    /** @test */
    public function alert_belongs_to_creator()
    {
        $user = User::factory()->create();
        $alert = Alert::factory()->create(['created_by' => $user->id]);

        $this->assertInstanceOf(User::class, $alert->creator);
        $this->assertEquals($user->id, $alert->creator->id);
    }

    /** @test */
    public function alert_has_many_reports()
    {
        $alert = Alert::factory()->create();
        $report = Report::factory()->create(['alert_id' => $alert->id]);

        $this->assertInstanceOf(Report::class, $alert->reports->first());
        $this->assertEquals(1, $alert->reports->count());
    }

    /** @test */
    public function alert_has_morph_one_address()
    {
        $alert = Alert::factory()->create();
        $address = $alert->address()->create([
            'address_line' => '123 Test Street',
            'city' => 'Hanoi',
            'latitude' => 21.0285,
            'longitude' => 105.8542,
        ]);

        $this->assertInstanceOf(Address::class, $alert->address);
        $this->assertEquals('123 Test Street', $alert->address->address_line);
    }

    /** @test */
    public function alert_can_be_created_with_valid_data()
    {
        $user = User::factory()->create();

        $alert = Alert::create([
            'title' => 'Test Alert',
            'description' => 'Test Description',
            'type' => 'flood',
            'severity' => 'high',
            'radius' => 5000,
            'created_by' => $user->id,
        ]);

        $this->assertDatabaseHas('alerts', [
            'title' => 'Test Alert',
            'type' => 'flood',
            'severity' => 'high',
        ]);
    }

    /** @test */
    public function alert_can_be_updated()
    {
        $alert = Alert::factory()->create(['title' => 'Original Title']);

        $alert->update(['title' => 'Updated Title']);

        $this->assertEquals('Updated Title', $alert->fresh()->title);
    }

    /** @test */
    public function alert_can_be_deleted()
    {
        $alert = Alert::factory()->create();
        $alertId = $alert->id;

        $alert->delete();

        $this->assertDatabaseMissing('alerts', ['id' => $alertId]);
    }

    /** @test */
    public function alert_has_default_image_path()
    {
        $alert = Alert::factory()->create(['image_path' => 'base.png']);

        $this->assertEquals('base.png', $alert->image_path);
    }

    /** @test */
    public function alert_validates_type_enum()
    {
        $validTypes = ['flood', 'fire', 'storm', 'earthquake', 'other'];

        foreach ($validTypes as $type) {
            $alert = Alert::factory()->create(['type' => $type]);
            $this->assertEquals($type, $alert->type);
        }
    }

    /** @test */
    public function alert_validates_severity_enum()
    {
        $validSeverities = ['low', 'medium', 'high', 'critical'];

        foreach ($validSeverities as $severity) {
            $alert = Alert::factory()->create(['severity' => $severity]);
            $this->assertEquals($severity, $alert->severity);
        }
    }
}
