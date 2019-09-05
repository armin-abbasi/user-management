<?php


namespace App\Libraries\Admin;


use App\Exceptions\GroupIsNotEmptyException;
use App\Exceptions\UserAlreadyAttachedException;
use App\Models\Group;
use App\Models\User;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class Groups
{
    /**
     * @return mixed
     */
    public function getAll()
    {
        return Group::paginate(5);
    }

    /**
     * @param $input
     * @return mixed
     */
    public function create($input)
    {
        return Group::create($input);
    }

    /**
     * @param $id
     * @return int
     * @throws GroupIsNotEmptyException
     */
    public function delete($id)
    {
        $group = Group::find($id);

        if (!$group) {
            throw new NotFoundResourceException(trans('messages.groups.not_found'));
        }

        if ($group->users()->exists()) {
            throw new GroupIsNotEmptyException(trans('messages.groups.not_empty'), -5);
        }

        if ($result = Group::destroy($id)) {
            return $result;
        }

        throw new NotFoundResourceException(trans('messages.groups.not_found'));
    }

    /**
     * @param $id
     * @param $userId
     * @return mixed
     * @throws UserAlreadyAttachedException|NotFoundResourceException
     */
    public function attach($id, $userId)
    {
        $group = Group::find($id);

        if (!$group) {
            throw new NotFoundResourceException(trans('messages.groups.not_found'));
        }

        if (!User::find($userId)) {
            throw new NotFoundResourceException(trans('messages.users.not_found'));
        }

        if ($group->users()->where('user_id', $userId)->first()) {
            throw new UserAlreadyAttachedException(trans('messages.groups.already_attached'), -4);
        }

        return $group->users()->attach($userId);
    }
}