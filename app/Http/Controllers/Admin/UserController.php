<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateUserRequest;
use App\Libraries\Api\Response;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function create(CreateUserRequest $request)
    {
        $inputs = $request->only(['name', 'email', 'password']);

        $user = User::create($inputs);

        return (new Response(0, trans('messages.users.created'), $user));
    }
}
