<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    public function restoreDatabase()
    {

        Schema::connection(env('DB_CONNECTION'))->drop('privileges');
        Schema::connection(env('DB_CONNECTION'))->drop('roles');
        Schema::connection(env('DB_CONNECTION'))->drop('users');
        Schema::connection(env('DB_CONNECTION'))->drop('tenants');


        Artisan::call('migrate', [
            '--path' => "app/database/migrations",
            '--force'   => true
        ]);

    }
}
