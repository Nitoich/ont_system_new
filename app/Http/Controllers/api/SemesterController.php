<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Semesters\CreateSemesterRequest;
use App\Http\Resources\Semester\SemesterResource;
use App\Models\Semester;
use App\Services\SemesterService;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index() {
        $semesters = Semester::query();
        if(isset($request->pagination) && $request->pagination == 'false') {
            $semesters = $semesters->get();
        } else {
            $semesters = $semesters->paginate($_GET['per_page'] ?? 10);
        }
        return response()->json(
            SemesterResource::collection($semesters)->response()->getData(true)
        )->setStatusCode(200);
    }

    public function store(
        CreateSemesterRequest $request,
        SemesterService $semesterService
    ) {
        return response()->json([
            'data' => SemesterResource::make($semesterService->create($request->all()))
        ])->setStatusCode(201);
    }

    public function show(
        SemesterService $semesterService,
        int $id
    ) {
        return response()->json([
            'data' => $semesterService->getById($id)
        ])->setStatusCode(200);
    }

    public function update(
        SemesterService $semesterService,
        Request $request,
        int $id
    )
    {
        return response()->json([
            'data' => $semesterService->update($id, $request->all())
        ])->setStatusCode(200);
    }

    public function destroy(
        SemesterService $semesterService,
        int $id
    ) {
        return response()->json($semesterService->delete($id))->setStatusCode(200);
    }
}
