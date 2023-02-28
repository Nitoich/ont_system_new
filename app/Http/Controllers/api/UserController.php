<?php

namespace App\Http\Controllers\api;

use App\Filters\UsersFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\AddRolesRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserRoleResource;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getMe() {
        return response()->json(UserResource::make(Auth::user()))->setStatusCode(200);
    }

    public function getRoles(
        int $id
    ) {
        return response()->json(Auth::user()->roles);
    }

    public function index(
        UsersFilter $filter
    ) {
        $users = User::query()->filter($filter)->paginate(10);
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
}
