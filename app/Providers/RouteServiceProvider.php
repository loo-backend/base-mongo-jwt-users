<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {

        $this->mapApiAuthRoutes();
        $this->mapApiUsersRoutes();
        $this->mapApiRolesRoutes();
        $this->mapApiPrivilegesRoutes();
        $this->mapApiTenantsRoutes();

        $this->mapWebRoutes();

        //
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
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "users" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiUsersRoutes()
    {
        Route::prefix('api/v1/users')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api-users.php'));
    }

    /**
     * Define the "roles" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRolesRoutes()
    {
        Route::prefix('api/v1/roles')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api-roles.php'));
    }

    /**
     * Define the "privileges" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiPrivilegesRoutes()
    {
        Route::prefix('api/v1')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api-privileges.php'));
    }


    /**
     * Define the "tenants" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiTenantsRoutes()
    {
        Route::prefix('api/v1')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api-tenants.php'));
    }

    /**
     * Define the "auth" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiAuthRoutes()
    {
        Route::prefix('api/v1/auth')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api-auth.php'));
    }


}
