<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateUserRequest;
use App\Libraries\Admin\Services\Users;
use App\Libraries\Api\Response;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * @var Users $service
     */
    public $service;

    /**
     * UserController constructor.
     * @param Users $userService
     */
    public function __construct(Users $userService)
    {
        $this->service = $userService;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->service->getAll();

        return (new Response(0, trans('messages.users.get'), $users))->toJson();
    }

    /**
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(CreateUserRequest $request)
    {
        $inputs = $request->only(['name', 'email', 'password']);

        $user = $this->service->create($inputs);

        return (new Response(0, trans('messages.users.created'), $user))->toJson();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $this->service->delete($id);

        return (new Response(0, trans('messages.users.deleted'), null))->toJson();
    }
}
