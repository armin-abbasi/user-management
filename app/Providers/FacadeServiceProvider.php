<?php

namespace App\Providers;

use App\Libraries\Admin\Services\Groups;
use App\Libraries\Admin\Services\Users;
use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind('userService', function () {
            return new Users();
        });

        app()->bind('groupService', function () {
            return new Groups();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
