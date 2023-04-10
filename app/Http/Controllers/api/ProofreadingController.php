<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Proofreadings\CreateProofreading;
use App\Http\Requests\Proofreadings\UpdateProofreadingRequest;
use App\Http\Resources\Proofreading\ProofreadingResource;
use App\Models\Proofreading;
use App\Services\ProofreadingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProofreadingController extends Controller
{
    private ProofreadingService $proofreadingService;

    public function __construct(ProofreadingService $proofreadingService)
    {
        $this->proofreadingService = $proofreadingService;
    }

    public function store(
        CreateProofreading $request
    ) : JsonResponse
    {
        return response()->json([
            'data' => $this->proofreadingService->create($request->all())
        ])->setStatusCode(201);
    }

    public function index(): JsonResponse
    {
        $proofreading = Proofreading::query();
        if(isset($request->pagination) && $request->pagination == 'false') {
            $proofreading = $proofreading->get();
        } else {
            $proofreading = $proofreading->paginate($_GET['per_page'] ?? 10);
        }
        return response()->json(ProofreadingResource::collection($proofreading)->response()->getData(true))->setStatusCode(200);
    }

    public function show(
        int $id
    ): JsonResponse
    {
        return response()->json([
            'data' => ProofreadingResource::make($this->proofreadingService->getById($id))
        ])->setStatusCode(200);
    }

    public function update(
        UpdateProofreadingRequest $request,
        int $id
    ): JsonResponse
    {
        return response()->json([
            'data' => $this->proofreadingService->update($id, $request->all())
        ])->setStatusCode(200);
    }

    public function delete(
        int $id
    ) : JsonResponse
    {
        return response()->json($this->proofreadingService->delete($id))->setStatusCode(200);
    }
}
