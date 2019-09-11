<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateUserRequest;
use App\Libraries\Admin\Facades\UserService;
use App\Libraries\Api\Response;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = UserService::getAll();

        return (new Response(0, trans('messages.users.get'), $users))->toJson();
    }

    /**
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(CreateUserRequest $request)
    {
        $inputs = $request->only(['name', 'email', 'password']);

        $user = UserService::create($inputs);

        return (new Response(0, trans('messages.users.created'), $user))->toJson();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        UserService::delete($id);

        return (new Response(0, trans('messages.users.deleted'), null))->toJson();
    }
}
