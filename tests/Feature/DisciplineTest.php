<?php

namespace Tests\Feature;

use App\Models\Discipline;
use App\Models\Speciality;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DisciplineTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_discipline()
    {
        $speciality = Speciality::factory()->create();
        $discipline_fields = [
            'name' => 'Test_Discipline',
            'slug' => 'test',
            'speciality_id' => $speciality->id
        ];
        $response = $this->withToken($this->getAccessNewUser())->post('/api/v1/discipline', $discipline_fields);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'name',
                'slug',
                'speciality_id'
            ]
        ]);
    }

    public function test_get_one_discipline() {
        $discipline = Discipline::factory()->create();
        $response = $this->withToken($this->getAccessNewUser())->get("/api/v1/discipline/{$discipline->id}");
        $response->assertStatus(200);
    }

    public function test_get_all_discipline() {
        $disciplines = Discipline::factory(10)->create();

        $response = $this->withAccess()->get('/api/v1/discipline');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'links',
            'meta'
        ]);
    }

    public function test_update_discipline() {
        $discipline = Discipline::factory()->create();
        $fields = [
            'name' => 'renamed',
            'slug' => 'renamed',
        ];

        $response = $this->withAccess()->patch("/api/v1/discipline/{$discipline->id}", $fields);

        $response->assertStatus(200);
        $response->assertJsonPath('data.id', $discipline->id);
        $response->assertJsonPath('data.name', $fields['name']);
        $response->assertJsonPath('data.slug', $fields['slug']);
    }

    public function test_delete_discipline() {
        $discipline = Discipline::factory()->create();
        $response = $this->withAccess()->delete("/api/v1/discipline/{$discipline->id}");
        $response->assertStatus(200);
    }
}
