<?php

namespace App\Http\Controllers\api;

use App\Filters\SlugAndNameFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Disciplines\CreateDisciplineRequest;
use App\Http\Resources\Discipline\DisciplineResource;
use App\Models\Discipline;
use App\Services\DisciplineService;
use Illuminate\Http\Request;

class DisciplineController extends Controller
{
    public function index(
        SlugAndNameFilter $filter
    )
    {
        $disciplines = Discipline::query()->filter($filter)->paginate($_GET['per_page'] ?? 10);
        return response()->json(DisciplineResource::collection($disciplines)->response()->getData(true))->setStatusCode(200);
    }

    public function store(
        CreateDisciplineRequest $request,
        DisciplineService $disciplineService
    )
    {
        return response()->json([
            'data' => DisciplineResource::make($disciplineService->create($request->all()))
        ])->setStatusCode(201);
    }

    public function show(
        DisciplineService $disciplineService,
        int $id
    )
    {
        return response()->json([
            'data' => $disciplineService->getById($id)
        ])->setStatusCode(200);
    }

    public function update(
        Request $request,
        DisciplineService $disciplineService,
        int $id
    )
    {
        return response()->json([
            'data' => $disciplineService->update($id, $request->all())
        ])->setStatusCode(200);
    }

    public function destroy(
        DisciplineService $disciplineService,
        int $id
    )
    {
        return response()->json($id)->setStatusCode(200);
    }
}
