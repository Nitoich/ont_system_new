<?php

namespace App\Http\Controllers\api;

use App\Filters\LoadFilter;
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

    public function show(
        LoadService $loadService,
        int $id
    ) {
        return response()->json([
            'data' => LoadResource::make($loadService->getById($id))
        ])->setStatusCode(200);
    }

    public function index(
        Request $request,
        LoadFilter $filter
    ) {
        $loads = null;
        if(isset($request->pagination) && $request->pagination == "false") {
            $loads = Load::query()->filter($filter)->get();
            return response()->json([
                'data' => LoadResource::collection($loads)
            ]);
        } else {
            $loads = Load::query()->filter($filter)->paginate($_GET['per_page'] ?? 10);
            return response()->json(LoadResource::collection($loads)->response()->getData(true));
        }

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
