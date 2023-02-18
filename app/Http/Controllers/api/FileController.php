<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Files\AddFileRequest;
use App\Services\FileService;
use Illuminate\Http\Request;
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

    public function show(
        Request $request,
        FileService $fileService,
        int $id
    ) {
        $file = $fileService->getById($id);
//        dd($file);
//        Storage::disk('files')->response();
//        dd(Storage::disk('files')->exists($file->name), $file);
        if($request->data) {
            return response()->json([
                'data' => $file
            ])->setStatusCode(200);
        }
        return Storage::disk('files')->download($file->name);
    }
}
