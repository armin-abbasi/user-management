<?php

namespace App\Libraries\Admin;

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
    public function create($input)
    {
        return User::create($input);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        if ($result = User::destroy($id)) {
            return $result;
        }

        throw new NotFoundResourceException(trans('messages.users.not_found'));
    }
}