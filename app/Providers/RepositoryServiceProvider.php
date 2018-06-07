<?php

namespace App\Providers;

use App\Entities\Log;
use App\Entities\Privilege;
use App\Entities\Role;
use App\Entities\Tenant;
use App\Entities\User;
use App\Repositories\Log\EloquentLogRepository;
use App\Repositories\Log\LogRepositoryInterface;
use App\Repositories\Privilege\EloquentPrivilegeRepository;
use App\Repositories\Privilege\PrivilegeRepositoryInterface;
use App\Repositories\Role\EloquentRoleRepository;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\Tenant\EloquentTenantRepository;
use App\Repositories\Tenant\TenantRepositoryInterface;
use App\Repositories\User\EloquentUserRepository;
use App\Repositories\User\UserRepositoryInterface;
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
        $this->app->bind(LogRepositoryInterface::class, function () {
            return new EloquentLogRepository(new Log());
        });

        $this->app->bind(PrivilegeRepositoryInterface::class, function () {
            return new EloquentPrivilegeRepository(new Privilege());
        });

        $this->app->bind(RoleRepositoryInterface::class, function () {
            return new EloquentRoleRepository(new Role());
        });

        $this->app->bind(TenantRepositoryInterface::class, function () {
            return new EloquentTenantRepository(new Tenant());
        });

        $this->app->bind(UserRepositoryInterface::class, function () {
            return new EloquentUserRepository(new User());
        });
    }
}
