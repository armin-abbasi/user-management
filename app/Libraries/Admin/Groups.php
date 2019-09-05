<?php


namespace App\Libraries\Admin;


use App\Models\Group;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class Groups
{
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
     */
    public function delete($id)
    {
        if ($result = Group::destroy($id)) {
            return $result;
        }

        throw new NotFoundResourceException(trans('messages.groups.not_found'));
    }
}