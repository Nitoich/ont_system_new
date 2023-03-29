<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserRoleResource;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
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
}
