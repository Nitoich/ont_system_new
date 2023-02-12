<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
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
    }
}
