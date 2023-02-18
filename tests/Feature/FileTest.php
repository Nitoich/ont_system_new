<?php

namespace Tests\Feature;

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
}
