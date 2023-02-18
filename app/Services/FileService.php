<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class FileService extends Service
{
    protected $model = File::class;

    public function create($file): \Illuminate\Database\Eloquent\Model
    {
        $exist_file = File::query()->where('hash', md5($file->getContent()))->first();
        if($exist_file) {
            return $exist_file;
        }

        $timestamp = strtotime('now');
        $filename = "{$timestamp}_{$file->getClientOriginalName()}";

        Storage::disk('files')->putFileAs('', $file, $filename);
        $fields = [
            'name' => $filename,
            'extension' => $file->getClientOriginalExtension(),
            'size' => $file->getSize(),
            'path' => Storage::disk('files')->url($filename),
            'hash' => md5($file->getContent())
        ];
        return parent::create($fields);
    }
}
