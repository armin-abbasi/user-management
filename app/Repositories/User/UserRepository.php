<?php


namespace App\Repositories\User;


use App\Models\User;
use App\Repositories\Base\BaseRepository;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new User();
    }
}