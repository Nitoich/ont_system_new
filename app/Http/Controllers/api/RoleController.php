<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\CreateRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use App\Http\Resources\User\UserRoleResource;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private RoleService $roleService;

    public function __construct(RoleService $service)
    {
        $this->roleService = $service;
    }

    public function index() {
        return response()->json(['data' => Role::all()])->setStatusCode(200);
    }

    public function show(
        RoleService $roleService,
        int $id
    ) {
        return response()->json([
            'data' => $roleService->getById($id)
        ])->setStatusCode(200);
    }

    public function store(
        RoleService $roleService,
        CreateRoleRequest $request
    ) {
        return response()->json([
            'data' => $roleService->create($request->all())
        ])->setStatusCode(201);
    }

    public function getRolePermissions(
        int $role_id
    ) {
        $role = $this->roleService->getById($role_id);
        return response()->json([
            'data' => $role->permissions
        ])->setStatusCode(200);
    }

    public function update(
        int $role_id,
        UpdateRoleRequest $request
    ): JsonResponse
    {
        return response()->json([
            'data' => $this->roleService->update($role_id, $request->all())
        ])->setStatusCode(200);
    }
}
