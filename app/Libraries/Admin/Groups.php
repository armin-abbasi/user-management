<?php


namespace App\Libraries\Admin;


use App\Exceptions\GroupIsNotEmptyException;
use App\Models\Group;
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

        if ($group->users()->exists()) {
            throw new GroupIsNotEmptyException(trans('messages.groups.not_empty'));
        }

        if ($result = Group::destroy($id)) {
            return $result;
        }

        throw new NotFoundResourceException(trans('messages.groups.not_found'));
    }
}