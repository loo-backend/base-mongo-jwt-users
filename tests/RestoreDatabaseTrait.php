<?php

namespace Tests;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

trait RestoreDatabaseTrait
{

    public function restoreDatabase()
    {

       // Schema::connection(env('DB_CONNECTION'))->drop('privileges');
       // Schema::connection(env('DB_CONNECTION'))->drop('roles');
       // Schema::connection(env('DB_CONNECTION'))->drop('users');
       // Schema::connection(env('DB_CONNECTION'))->drop('tenants');
       // Schema::connection(env('DB_CONNECTION'))->drop('role_users');

       Artisan::call('migrate', [
           '--path' => "app/database/migrations",
           '--force'   => true
       ]);

    }

}
