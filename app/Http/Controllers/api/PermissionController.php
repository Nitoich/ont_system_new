<?php

namespace App\Http\Controllers\api;

use App\Filters\PermissionsFilter;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(
        PermissionsFilter $filter
    ): JsonResponse
    {
        $permissions = Permission::query()->filter($filter)->get();
        return response()->json([
            'data' => $permissions
        ])->setStatusCode(200);
    }

    public function store(): JsonResponse
    {
        // TODO: implement this method later
        return response->json();
    }

    public function show(
        PermissionService $permissionService,
        int $id
    ): JsonResponse
    {
        return response()->json([
            'data' => $permissionService->getById($id)
        ])->setStatusCode(200);
    }
}
