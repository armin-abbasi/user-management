<?php


namespace App\Libraries\Admin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class GroupService
 * @method static mixed getAll()
 * @method static mixed create(array $input)
 * @method static boolean delete(int $id)
 * @method static mixed attach(int $groupId, int $userId)
 * @method static mixed detach(int $groupId, int $userId)
 */
class GroupService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'groupService';
    }
}