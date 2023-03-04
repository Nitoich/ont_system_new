<?php

namespace App\Http\Controllers\api;

use App\Filters\UsersFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\AddRolesRequest;
use App\Http\Requests\Users\CreateRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserRoleResource;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getMe() {
        return response()->json(UserResource::make(Auth::user()))->setStatusCode(200);
    }

    public function getRoles(
        UserService $userService,
        int $user_id
    ) {
        return response()->json([
            'data' => $userService->getById($user_id)->roles
        ]);
    }

    public function index(
        Request $request,
        UsersFilter $filter
    ) {
        $users = User::query()->filter($filter)->paginate(20);
//        dd(json_decode($users->toJson(), TRUE));
        return response()->json(UserResource::collection($users)->response()->getData(true))->setStatusCode(200);
    }

    public function getUser(
        UserService $userService,
        int $id
    ) {
        return response()->json([
            'data' => UserResource::make($userService->getById($id))
        ]);
    }

    public function update(
        UpdateUserRequest $request,
        UserService $userService,
        int $id
    ) {
        return response()->json($userService->update($id, $request->all()));
    }

    public function setRoles(
        AddRolesRequest $request,
        UserService $userService,
        int $user_id
    ) {
        $user = $userService->getById($user_id);
        $roles_ids = $request->roles_ids;
//        $roles = Role::query();
//        foreach ($roles_ids as $roles_id) {
//            $roles = $roles->orWhere('id', $roles_id);
//        }
//        $roles = $roles->get();
        $user->roles()->sync($roles_ids);

        return response()->json()->setStatusCode(200);
    }

    public function store(
        CreateRequest $request,
        UserService $userService
    ) {
        $user = $userService->create($request->all());
        return response()->json([
            'data' => UserResource::make($user)
        ])->setStatusCode(201);
    }
}
