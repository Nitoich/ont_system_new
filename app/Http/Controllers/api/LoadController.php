<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loads\CreateLoadRequest;
use App\Http\Resources\Loads\LoadResource;
use App\Models\Load;
use App\Services\LoadService;
use Illuminate\Http\Request;

class LoadController extends Controller
{
    public function store(
        CreateLoadRequest $request,
        LoadService $loadService
    ) {
        return response()->json([
            'data' => LoadResource::make($loadService->create($request->all()))
        ])->setStatusCode(201);
    }

    public function index() {
        $loads = Load::query()->paginate(10);
        return response()->json(
            LoadResource::collection($loads)->response()->getData(true)
        );
    }

    public function update(
        Request $request,
        LoadService $loadService,
        int $id
    ) {
        return response()->json([
            'data' => LoadResource::make($loadService->update($id, $request->all()))
        ])->setStatusCode(200);
    }

    public function destroy(
        LoadService $loadService,
        int $id
    ) {
        return response()->json($loadService->delete($id))->setStatusCode(200);
    }
}
