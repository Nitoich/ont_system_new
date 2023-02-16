<?php

namespace Tests\Feature;

use App\Models\Group;
use Database\Factories\GroupFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GroupTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_group()
    {
        $user = $this->createTestUser();
        $response = $this->withToken($user['session']->access_token)->post('/api/v1/group', [
            'name' => 'test_group',
            'slug' => 'test'
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'name',
            'slug'
        ]);
    }

    public function test_get_group() {
        $user = $this->createTestUser();
        $group = Group::factory()->create();
        $response = $this->withToken($user['session']->access_token)->get("/api/v1/group/{$group->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'name',
            'slug'
        ]);
        $response->assertJsonPath('name', $group->name);
        $response->assertJsonPath('slug', $group->slug);
    }

    public function test_get_groups() {
        $user = $this->createTestUser();
        Group::factory(24)->create();
        $response = $this->withToken($user['session']->access_token)->get('/api/v1/group');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'links',
            'meta'
        ]);
    }

    public function test_update_group() {
        $user = $this->createTestUser();
        $group = Group::factory()->create();
        $response = $this->withToken($user['session']->access_token)->patch("/api/v1/group/{$group->id}", [
            'name' => 'renamed',
            'slug' => 'renamed'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'name',
            'slug'
        ]);

        $response->assertJsonPath('name', 'renamed');
        $response->assertJsonPath('slug', 'renamed');
    }

    public function test_delete_group() {
        $user = $this->createTestUser();
        $group = Group::factory()->create();
        $response = $this->withToken($user['session']->access_token)->delete("/api/v1/group/{$group->id}");
        $response->assertStatus(200);
    }
}
