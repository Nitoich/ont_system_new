<?php

namespace App\Http\Controllers\api;

use App\Filters\PermissionsFilter;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(
        PermissionsFilter $filter
    )
    {
        $permissions = Permission::query()->filter($filter)->get();
        return response()->json([
            'data' => $permissions
        ])->setStatusCode(200);
    }
}
