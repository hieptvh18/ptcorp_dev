<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function boot()
    {
        $this->app->bind(\Modules\Auth\Repositories\RoleRepository::class, \Modules\Auth\Repositories\RoleRepositoryEloquent::class);
        $this->app->bind(\Modules\Auth\Repositories\UserRepository::class, \Modules\Auth\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\Modules\Auth\Repositories\PermissionRepository::class, \Modules\Auth\Repositories\PermissionRepositoryEloquent::class);

        //:end-bindings::end-bindings:
    }
}
