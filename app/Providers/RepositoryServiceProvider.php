<?php

namespace App\Providers;


use App\Entities\Log\Log;
use App\Entities\Log\LogRepository;
use App\Entities\Privilege\Privilege;
use App\Entities\Privilege\PrivilegeRepository;
use App\Entities\Role\Role;
use App\Entities\Role\RoleRepository;
use App\Entities\Tenant\Tenant;
use App\Entities\Tenant\TenantRepository;
use App\Entities\User\User;
use App\Entities\User\UserRepository;
use App\Repositories\Log\LogRepositoryEloquent;
use App\Repositories\Privilege\PrivilegeRepositoryEloquent;
use App\Repositories\Role\RoleRepositoryEloquent;
use App\Repositories\Tenant\TenantRepositoryEloquent;
use App\Repositories\User\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LogRepository::class, function () {
            return new LogRepositoryEloquent(new Log());
        });

        $this->app->bind(PrivilegeRepository::class, function () {
            return new PrivilegeRepositoryEloquent(new Privilege());
        });

        $this->app->bind(RoleRepository::class, function () {
            return new RoleRepositoryEloquent(new Role());
        });

        $this->app->bind(TenantRepository::class, function () {
            return new TenantRepositoryEloquent(new Tenant());
        });

        $this->app->bind(UserRepository::class, function () {
            return new UserRepositoryEloquent(new User());
        });
    }
}
