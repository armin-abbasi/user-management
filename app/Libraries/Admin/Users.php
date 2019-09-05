<?php


namespace App\Libraries\Admin;


use App\Models\User;

class Users
{
    /**
     * @param $input
     * @return mixed
     */
    public function create($input)
    {
        return User::create($input);
    }
}