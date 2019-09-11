<?php


namespace App\Libraries\Admin\Facades;

use Illuminate\Support\Facades\Facade;

class UserService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'userService';
    }
}