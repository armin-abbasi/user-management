<?php

namespace App\Http\Controllers\Admin;

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

    public function __construct(Groups $groupsService)
    {
        $this->service = $groupsService;
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
        $this->service->delete($id);

        return (new Response(0, trans('messages.groups.deleted'), null))->toJson();
    }
}
