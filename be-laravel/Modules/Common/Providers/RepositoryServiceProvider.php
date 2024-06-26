<?php

namespace Modules\Common\Providers;

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
    public function boot()
    {
        $this->app->bind(\Modules\Common\Repositories\CountryRepository::class, \Modules\Common\Repositories\CountryRepositoryEloquent::class);
        $this->app->bind(\Modules\Common\Repositories\ProvinceRepository::class, \Modules\Common\Repositories\ProvinceRepositoryEloquent::class);
        $this->app->bind(\Modules\Common\Repositories\DistrictRepository::class, \Modules\Common\Repositories\DistrictRepositoryEloquent::class);
        $this->app->bind(\Modules\Common\Repositories\WardRepository::class, \Modules\Common\Repositories\WardRepositoryEloquent::class);
        //:end-bindings::end-bindings:
    }
}
