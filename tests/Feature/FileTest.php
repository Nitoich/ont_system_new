<?php

namespace Tests\Feature;

use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_upload_file()
    {
        Storage::fake('files');
        $response = $this->withAccess()->post('/api/v1/file', [
            'file' => UploadedFile::fake()->image('avatar.jpg')
        ]);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'extension',
                'size',
                'path'
            ]
        ]);
        $response_data = json_decode($response->getContent(), TRUE);
        Storage::disk('files')->assertExists($response_data['data']['name']);
    }

    public function test_get_file() {
//        Storage::fake('files');
        $file = File::factory()->create();
        $response = $this->withAccess()->get("/api/v1/file/{$file->id}");
        $response->assertStatus(200);
    }

    public function test_get_file_data() {
//        Storage::fake('files');
        $file = File::factory()->create();
        $response = $this->withAccess()->get("/api/v1/file/{$file->id}?data=true");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'extension',
                'size',
                'path'
            ]
        ]);
    }
}
