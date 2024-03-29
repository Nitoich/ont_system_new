<?php

namespace App\Http\Controllers\api;

use App\Filters\GroupsFilter;
use App\Filters\SlugAndNameFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Groups\CreateGroupRequest;
use App\Http\Resources\Group\GroupResource;
use App\Models\Group;
use App\Services\GroupService;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function create(
        CreateGroupRequest $request,
        GroupService $groupService
    ) {
        return response()->json(GroupResource::make($groupService->create($request->all())), 201);
    }

    public function getOne(
        GroupService $groupService,
        int $group_id
    ) {
        return response()->json(
            [
                'data' => GroupResource::make($groupService->getById($group_id))
            ], 200);
    }

    public function getAll(
        SlugAndNameFilter $filter,
        Request $request
    ) {
        $groups = Group::query()->filter($filter);
        if(isset($request->pagination) && $request->pagination == 'false') {
            $groups = $groups->get();
        } else {
            $groups = $groups->paginate($_GET['per_page'] ?? 10);
        }
        return response()->json(GroupResource::collection($groups)->response()->getData(true), 200);
    }

    public function update(
        Request $request,
        GroupService $groupService,
        int $group_id
    ) {
        return response()->json(GroupResource::make($groupService->update($group_id, $request->all())))->setStatusCode(200);
    }

    public function delete(
        GroupService $groupService,
        int $group_id
    ) {
        return response()->json($groupService->delete($group_id))->setStatusCode(200);
    }
}
