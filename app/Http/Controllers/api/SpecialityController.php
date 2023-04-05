<?php

namespace App\Http\Controllers\api;

use App\Filters\SlugAndNameFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Specialities\CreateSpecialityRequest;
use App\Http\Resources\Specialities\SpecialityResource;
use App\Models\Speciality;
use App\Services\SpecialityService;
use Illuminate\Http\Request;

class SpecialityController extends Controller
{
    public function index(
        SlugAndNameFilter $filter
    ) {
        $specialities = Speciality::query()->filter($filter)->paginate($_GET['per_page'] ?? 10);
        return response()->json(SpecialityResource::collection($specialities)->response()->getData(true));
    }

    public function store(
        SpecialityService $specialityService,
        CreateSpecialityRequest $request
    )
    {
        $speciality = $specialityService->create($request->all());
        return response()->json([
            'data' => SpecialityResource::make($speciality)
        ])->setStatusCode(201);
    }

    public function show(
        SpecialityService $specialityService,
        int $id
    )
    {
        $speciality = $specialityService->getById($id);
        return response()->json([
            'data' => SpecialityResource::make($speciality)
        ])->setStatusCode(200);
    }

    public function update(
        Request $request,
        SpecialityService $specialityService,
        int $id
    )
    {
        return response()->json([
            'data' => SpecialityResource::make($specialityService->update($id, $request->all()))
        ])->setStatusCode(200);
    }

    public function destroy(
        SpecialityService $specialityService,
        int $id
    )
    {
        return response()->json($specialityService->delete($id));
    }
}
