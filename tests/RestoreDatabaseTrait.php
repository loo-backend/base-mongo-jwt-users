<?php

namespace Tests;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

trait RestoreDatabaseTrait
{

    protected $connection = 'main';

    public function __construct()
    {

        Schema::connection($this->connection)->drop('privileges');
        Schema::connection($this->connection)->drop('roles');
        Schema::connection($this->connection)->drop('users');
        Schema::connection($this->connection)->drop('tenants');
        Schema::connection($this->connection)->drop('role_users');

        //

        Artisan::call('migrate', [
            '--path' => "app/database/migrations",
            '--force'   => true
        ]);

    }

}
