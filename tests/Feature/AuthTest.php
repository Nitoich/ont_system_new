<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register_new_user()
    {
        $response = $this->post('/api/v1/register', [
            'email' => 'test@test',
            'password' => 'test',
            'first_name' => 'Nikita',
            'last_name' => 'Kargaev',
            'surname' => 'Tarasovich',
            'device_name' => 'Feature_Testing',
            'birth_day' => '2002-03-16'
        ]);
        $response->assertStatus(201);
        $json = json_decode($response->getContent(), TRUE);
        $this->assertIsString($json['data']['access_token']);
        $this->assertIsString($json['data']['refresh_token']);
    }

    public function test_login_in_user() {
        $this->test_register_new_user();
        $response = $this->post('/api/v1/login', [
            'email' => 'test@test',
            'password' => 'test',
            'device_name' => 'Feature_Testing'
        ]);

        $response->assertStatus(200);
        $json = json_decode($response->getContent(), TRUE);
        $this->assertIsString($json['data']['access_token']);
        $this->assertIsString($json['data']['refresh_token']);
        return $json;
    }

    public function test_get_authorized_user_data() {
        $session_data = $this->test_login_in_user();
        $response = $this->withToken($session_data['data']['access_token'])->get('/api/v1/me');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'first_name',
            'last_name',
            'surname',
            'email',
            'birth_day'
        ]);
    }

    public function test_get_error_unauthorized() {
        $response = $this->get('/api/v1/me');
        $response->assertStatus(401);
    }

//    public function test_get_my_sessions() {
//        //
//    }
}
