<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = Role::where('name', 'admin')->first();

        $admin = new User();
        $admin->name = 'Admin Name';
        $admin->email = 'admin@local';
        $admin->password = 'abc';
        $admin->save();
        $admin->roles()->attach($role_admin);

        $user = new User();
        $user->name = 'Regular User';
        $user->email = 'regular1@local';
        $user->password = 'abc';
        $user->save();

        $user = new User();
        $user->name = 'Regular User 2';
        $user->email = 'regular2@local';
        $user->password = 'abc';
        $user->save();

        $user = new User();
        $user->name = 'Regular User 3';
        $user->email = 'regular3@local';
        $user->password = 'abc';
        $user->save();
    }
}
