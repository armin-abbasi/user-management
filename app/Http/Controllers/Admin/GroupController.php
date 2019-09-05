<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\GroupIsNotEmptyException;
use App\Exceptions\UserAlreadyAttachedException;
use App\Http\Requests\CreateGroupRequest;
use App\Libraries\Admin\Groups;
use App\Http\Controllers\Controller;
use App\Libraries\Api\Response;

class GroupController extends Controller
{
    /**
     * @var Groups $service
     */
    public $service;

    /**
     * GroupController constructor.
     * @param Groups $groupsService
     */
    public function __construct(Groups $groupsService)
    {
        $this->service = $groupsService;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = $this->service->getAll();

        return (new Response(0, trans('messages.groups.get'), $groups))->toJson();
    }

    /**
     * @param CreateGroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(CreateGroupRequest $request)
    {
        $inputs = $request->only(['name', 'description']);

        $user = $this->service->create($inputs);

        return (new Response(0, trans('messages.groups.created'), $user))->toJson();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $this->service->delete($id);
        } catch (GroupIsNotEmptyException $e) {
            return (new Response(-1, $e->getMessage(), null))->toJson();
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
            $result = $this->service->attach($id, $userId);
        } catch (UserAlreadyAttachedException $e) {
            return (new Response(-4, $e->getMessage(), null))->toJson();
        }

        return (new Response(0, trans('messages.groups.attached'), $result))->toJson();
    }
}
