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
//        dd($response->getContent());
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

    public function test_get_specialities() {
        $specialities = Speciality::factory(20)->create();
        $response = $this->withToken($this->getAccessNewUser())->get('/api/v1/speciality');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'links',
            'meta'
        ]);
    }

    public function test_update_speciality() {
        $speciality = Speciality::factory()->create();
        $response = $this->withToken($this->getAccessNewUser())->patch("/api/v1/speciality/{$speciality->id}", [
            'name' => 'renamed',
            'slug' => 'renamed'
        ]);
        $response->assertStatus(200);
        $response->assertJsonPath('data.name', 'renamed');
        $response->assertJsonPath('data.slug', 'renamed');
    }

    public function test_delete_speciality() {
        $speciality = Speciality::factory()->create();
        $response = $this->withToken($this->getAccessNewUser())->delete("/api/v1/speciality/{$speciality->id}");
        $response->assertStatus(200);
    }
}
