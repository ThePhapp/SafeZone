<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    /** @test */
    public function admin_can_view_users_index()
    {
        $this->actingAs($this->admin);

        User::factory()->count(10)->create();

        $response = $this->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
        $response->assertViewHas('users');
    }

    /** @test */
    public function users_index_is_paginated()
    {
        $this->actingAs($this->admin);

        User::factory()->count(20)->create();

        $response = $this->get(route('admin.users.index'));

        $response->assertStatus(200);
        $users = $response->viewData('users');
        $this->assertEquals(15, $users->perPage());
    }

    /** @test */
    public function admin_can_view_edit_user_form()
    {
        $this->actingAs($this->admin);

        $user = User::factory()->create();

        $response = $this->get(route('admin.users.edit', $user->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.edit');
        $response->assertViewHas('user');
    }

    /** @test */
    public function admin_can_update_user()
    {
        $this->actingAs($this->admin);

        $user = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@test.com',
            'role' => 'user',
        ]);

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated@test.com',
            'role' => 'admin',
        ];

        $response = $this->put(route('admin.users.update', $user->id), $updateData);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'User updated successfully.');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@test.com',
            'role' => 'admin',
        ]);
    }

    /** @test */
    public function user_update_validates_required_fields()
    {
        $this->actingAs($this->admin);

        $user = User::factory()->create();

        $response = $this->put(route('admin.users.update', $user->id), [
            'name' => '',
            'email' => '',
            'role' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'role']);
    }

    /** @test */
    public function user_update_validates_email_format()
    {
        $this->actingAs($this->admin);

        $user = User::factory()->create();

        $response = $this->put(route('admin.users.update', $user->id), [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'role' => 'user',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function user_update_validates_max_lengths()
    {
        $this->actingAs($this->admin);

        $user = User::factory()->create();

        $response = $this->put(route('admin.users.update', $user->id), [
            'name' => str_repeat('a', 300),
            'email' => str_repeat('a', 250) . '@test.com',
            'role' => 'user',
        ]);

        $response->assertSessionHasErrors(['name', 'email']);
    }

    /** @test */
    public function admin_can_delete_user()
    {
        $this->actingAs($this->admin);

        $user = User::factory()->create();
        $userId = $user->id;

        $response = $this->delete(route('admin.users.destroy', $user->id));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'User deleted successfully.');

        $this->assertDatabaseMissing('users', ['id' => $userId]);
    }

    /** @test */
    public function regular_user_cannot_access_admin_users()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $response = $this->get(route('admin.users.index'));

        $response->assertStatus(403);
    }

    /** @test */
    public function guest_cannot_access_admin_users()
    {
        $response = $this->get(route('admin.users.index'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function admin_cannot_edit_nonexistent_user()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.users.edit', 99999));

        $response->assertStatus(404);
    }

    /** @test */
    public function admin_cannot_update_nonexistent_user()
    {
        $this->actingAs($this->admin);

        $response = $this->put(route('admin.users.update', 99999), [
            'name' => 'Test',
            'email' => 'test@test.com',
            'role' => 'user',
        ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function admin_cannot_delete_nonexistent_user()
    {
        $this->actingAs($this->admin);

        $response = $this->delete(route('admin.users.destroy', 99999));

        $response->assertStatus(404);
    }
}
