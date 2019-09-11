<?php


namespace App\Libraries\Admin\Facades;

use Illuminate\Support\Facades\Facade;

class GroupService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'groupService';
    }
}