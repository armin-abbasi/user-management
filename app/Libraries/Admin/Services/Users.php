<?php

namespace App\Libraries\Admin\Services;

use App\Models\User;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class Users
{
    /**
     * @return mixed
     */
    public function getAll()
    {
        return User::paginate(5);
    }

    /**
     * @param $input
     * @return mixed
     */
    public function create(array $input)
    {
        return User::create($input);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        if ($result = User::destroy($id)) {
            return $result;
        }

        throw new NotFoundResourceException(trans('messages.users.not_found'));
    }
}