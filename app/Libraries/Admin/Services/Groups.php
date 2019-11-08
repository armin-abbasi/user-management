<?php

namespace App\Libraries\Admin\Services;

use App\Exceptions\GroupIsNotEmptyException;
use App\Exceptions\UserAlreadyAttachedException;
use App\Models\Group;
use App\Models\User;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class Groups
{
    const PAGE_COUNT = 5;

    /**
     * @return mixed
     */
    public function getAll()
    {
        return Group::paginate(self::PAGE_COUNT);
    }

    /**
     * @param $input
     * @return mixed
     */
    public function create(array $input)
    {
        return Group::create($input);
    }

    /**
     * @param $id
     * @return int
     * @throws GroupIsNotEmptyException
     */
    public function delete(int $id): bool
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
    public function attach(int $id, int $userId)
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

    /**
     * @param $id
     * @param $userId
     * @return mixed
     */
    public function detach(int $id, int $userId)
    {
        $group = Group::find($id);

        if (!$group) {
            throw new NotFoundResourceException(trans('messages.groups.not_found'));
        }

        if (!User::find($userId)) {
            throw new NotFoundResourceException(trans('messages.users.not_found'));
        }

        return $group->users()->detach($userId);
    }
}