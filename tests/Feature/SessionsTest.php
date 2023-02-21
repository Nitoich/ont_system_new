<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Session;
use App\Models\User;
use Tests\TestCase;

class SessionsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_get_self_sessions()
    {
        $user = $this->createTestUser();
        $response = $this->withToken($user['session']->access_token)->get('/api/v1/session');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }

    public function test_refresh_token() {
        $session = Session::factory()->create();
        $response = $this->withCookie('refresh_token', $session->token)->get('/api/v1/session/refresh');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'access_token'
            ]
        ]);
        $response->assertCookie('refresh_token');
    }
}
