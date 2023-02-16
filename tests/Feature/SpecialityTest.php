<?php

namespace Tests\Feature;

use App\Models\Speciality;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SpecialityTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_speciality()
    {
        $response = $this->withToken($this->getAccessNewUser())->post('/api/v1/speciality', [
            'name' => 'test_speciality',
            'slug' => 'test',

        ]);
        $response->assertStatus(201);
        $response->assertJsonPath('data.name', 'test_speciality');
        $response->assertJsonPath('data.slug', 'test');
    }

    public function test_get_one_speciality() {
        $speciality = Speciality::factory()->create();
        $response = $this->withToken($this->getAccessNewUser())->get("/api/v1/speciality/{$speciality->id}");
        $response->assertStatus(200);
        $response->assertJsonPath('data.id', $speciality->id);
        $response->assertJsonPath('data.name', $speciality->name);
        $response->assertJsonPath('data.slug', $speciality->slug);
    }
}
