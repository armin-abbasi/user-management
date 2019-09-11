<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\GroupIsNotEmptyException;
use App\Exceptions\UserAlreadyAttachedException;
use App\Http\Requests\CreateGroupRequest;
use App\Libraries\Admin\Facades\GroupService;
use App\Http\Controllers\Controller;
use App\Libraries\Api\Response;

class GroupController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = GroupService::getAll();

        return (new Response(0, trans('messages.groups.get'), $groups))->toJson();
    }

    /**
     * @param CreateGroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(CreateGroupRequest $request)
    {
        $inputs = $request->only(['name', 'description']);

        $group = GroupService::create($inputs);

        return (new Response(0, trans('messages.groups.created'), $group))->toJson();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            GroupService::delete($id);
        } catch (GroupIsNotEmptyException $e) {
            return (new Response($e->getCode(), $e->getMessage(), null))->toJson();
        }

        return (new Response(0, trans('messages.groups.deleted'), null))->toJson();
    }

    /**
     * @param $id
     * @param $userId
     * @return \Illuminate\Http\Response
     */
    public function attach($id, $userId)
    {
        try {
            $result = GroupService::attach($id, $userId);
        } catch (UserAlreadyAttachedException $e) {
            return (new Response($e->getCode(), $e->getMessage(), null))->toJson();
        }

        return (new Response(0, trans('messages.groups.attached'), $result))->toJson();
    }

    /**
     * @param $id
     * @param $userId
     * @return \Illuminate\Http\Response
     */
    public function detach($id, $userId)
    {
        $result = GroupService::detach($id, $userId);

        return (new Response(0, trans('messages.groups.detached'), $result))->toJson();
    }
}
