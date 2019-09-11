<?php


namespace App\Libraries\Admin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class UserService
 * @method static mixed getAll()
 * @method static mixed create(array $input)
 * @method static boolean delete(int $userId)
 */
class UserService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'userService';
    }
}