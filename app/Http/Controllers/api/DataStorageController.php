<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Utils\DataStorage;
use App\Services\DataStorageService;
use Illuminate\Http\Exceptions\HttpResponseException;
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

    public function put(
        DataStorageService $service,
        string $key,
        Request $request
    ): JsonResponse
    {
        $data = DataStorage::query()->where('key', $key)->first();
        if(!$data) {
            $data = $service->create([
                'value' => $request->all()
            ]);
            return response()->json([
                'data' => $data->value
            ])->setStatusCode(201);
        }
        $data->update([
            'value' => array_merge($data->value, $request->all())
        ]);
        return response()->json([
            'data' => $data->value
        ])->setStatusCode(200);
    }

}
