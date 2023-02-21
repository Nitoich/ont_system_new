<?php

namespace Tests\Feature;

use App\Models\Discipline;
use App\Models\Group;
use App\Models\Load;
use App\Models\Semester;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoadTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_loads()
    {
        $loads = Load::factory(10)->create();
        $response = $this->withAccess()->get('/api/v1/load');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'links',
            'meta'
        ]);
    }

    public function test_create_load() {
        $semester = Semester::factory()->create();
        $group = Group::factory()->create();
        $discipline = Discipline::factory()->create();
        $fields = [
            'semester_id' => $semester->id,
            'group_id' => $group->id,
            'discipline_id' => $discipline->id,
            'type' => 'vacancy',
            'characteristic' => 'budget',
            'hours' => 2
        ];
        $response = $this->withAccess()->post('/api/v1/load', $fields);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'semester_id',
                'group_id',
                'group_name',
                'discipline_id',
                'discipline_name',
                'type',
                'characteristic',
                'hours'
            ]
        ]);
    }

    public function test_update_load() {
        $load = Load::factory()->create();
        $response = $this->withAccess()->patch("/api/v1/load/{$load->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'semester_id',
                'group_id',
                'group_name',
                'discipline_id',
                'discipline_name',
                'type',
                'characteristic',
                'hours'
            ]
        ]);
    }

    public function test_delete_load() {
        $load = Load::factory()->create();
        $response = $this->withAccess()->delete("/api/v1/load/{$load->id}");
        $response->assertStatus(200);
    }
}
