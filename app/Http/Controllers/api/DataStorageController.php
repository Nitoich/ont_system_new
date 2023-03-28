<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Utils\DataStorage;
use App\Services\DataStorageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DataStorageController extends Controller
{
    public function show(
        DataStorageService $service,
        string $key
    ): JsonResponse
    {
        $value = $service->getByKey($key);
        return response()->json([
            'data' => $value->value
        ])->setStatusCode(200);
    }
}
