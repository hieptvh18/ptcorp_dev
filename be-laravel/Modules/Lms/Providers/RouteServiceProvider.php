<?php

namespace Modules\Lms\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\Lms\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Lms', '/Routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('lms/api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Lms', '/Routes/api.php'));

        // api for member
        Route::prefix('lms/api/member')
            ->middleware('api', 'workspace_db')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Lms', '/Routes/scope/member.php'));

        // api for teacher
        Route::prefix('lms/api/teacher')
            ->middleware('api', 'workspace_db')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Lms', '/Routes/scope/teacher.php'));

        // api for admin
        Route::prefix('lms/api/admin')
            ->middleware('api', 'workspace_db')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Lms', '/Routes/scope/admin.php'));

        // api for user
        Route::prefix('lms/api/user')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Lms', '/Routes/scope/user.php'));

        // api for public
        Route::prefix('lms/api/public')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Lms', '/Routes/scope/public.php'));
    }
}
