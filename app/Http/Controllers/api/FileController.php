<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Files\AddFileRequest;
use App\Services\FileService;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function store(
        AddFileRequest $request,
        FileService $fileService
    ) {
        $file = $request->file('file');
        return response()->json([
            'data' => $fileService->create($file)
        ])->setStatusCode(201);
    }
}
