<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function createTestUser(string $role_slug = 'user'): array {
        $user = User::factory()->create();
        $user->roles()->save(Role::query()->where('slug', $role_slug)->first());
        $user_session = $user->createSession();
        return [
            'user' => $user,
            'session' => $user_session
        ];
    }

    public function test_get_self_sessions()
    {
        $user = $this->createTestUser();
        $response = $this->withToken($user['session']->access_token)->get('/api/v1/session');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
