<?php

namespace Tests\Feature;

use App\Models\Semester;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SemesterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_semester()
    {
        $fields = [
            'date_start' => '2022-09-01',
            'date_end' => '2022-12-31'
        ];
        $response = $this->withAccess()->post('/api/v1/semester', $fields);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'date_start',
                'date_end'
            ]
        ]);
    }

    public function test_get_semester() {
        $semester = Semester::factory()->create();
        $response = $this->withAccess()->get("/api/v1/semester/{$semester->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'date_start',
                'date_end'
            ]
        ]);
        $response->assertJsonPath('data.id', $semester->id);
        $response->assertJsonPath('data.date_start', $semester->date_start);
        $response->assertJsonPath('data.date_end', $semester->date_end);
    }

    public function test_get_all_semesters() {
        $semesters = Semester::factory(10)->create();
        $response = $this->withAccess()->get('/api/v1/semester');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'links',
            'meta'
        ]);
    }

    public function test_update_semester() {
        $semester = Semester::factory()->create();
        $new_value_for_attributes = [
            'date_start' => '2023-01-01',
            'date_end' => '2023-06-30'
        ];
        $response = $this->withAccess()->patch("/api/v1/semester/{$semester->id}", $new_value_for_attributes);
        $response->assertStatus(200);
        $response->assertJsonPath('data.date_start', $new_value_for_attributes['date_start']);
        $response->assertJsonPath('data.date_end', $new_value_for_attributes['date_end']);
    }
}
