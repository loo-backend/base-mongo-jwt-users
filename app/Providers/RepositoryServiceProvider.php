<?php

namespace App\Providers;

use App\Entities\Log;
use App\Entities\Privilege;
use App\Entities\Role;
use App\Entities\Tenant;
use App\Entities\User;
use App\Repositories\Log\EloquentLogRepository;
use App\Repositories\Log\LogRepositoryInterface;
use App\Repositories\Privilege\PrivilegeMongodbRepository;
use App\Repositories\Privilege\PrivilegeRepositoryInterface;
use App\Repositories\Role\RoleMongodbRepository;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\Tenant\TenantMongodbRepository;
use App\Repositories\Tenant\TenantRepositoryInterface;
use App\Repositories\User\UserMongodbRepository;
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
            return new PrivilegeMongodbRepository(new Privilege());
        });

        $this->app->bind(RoleRepositoryInterface::class, function () {
            return new RoleMongodbRepository(new Role());
        });

        $this->app->bind(TenantRepositoryInterface::class, function () {
            return new TenantMongodbRepository(new Tenant());
        });

        $this->app->bind(UserRepositoryInterface::class, function () {
            return new UserMongodbRepository(new User());
        });
    }
}
