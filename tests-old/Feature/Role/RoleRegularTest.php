<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\RestoreDatabaseTrait;
use Tests\TestCase;

class RoleRegularTest extends TestCase
{

    use RestoreDatabaseTrait;

     protected function setUp()
     {
         parent::setUp(); // TODO: Change the autogenerated stub

     }

    public function testRolesAdminAll()
    {

        Artisan::call('db:seed', [
            '--class'   => 'PrivilegeSeeder',
            '--force'   => true
        ]);

        Artisan::call('db:seed', [
            '--class'   => 'RoleRegularSeeder',
            '--force'   => true
        ]);

        Artisan::call('db:seed', [
            '--class'   => 'UserRegularSeeder',
            '--force'   => true
        ]);


        $this->assertTrue(true);

    }

    // public function testRestoreDatabase()
    // {
    //     $this->restoreDatabase();
    //     $this->assertTrue(true);
    // }

}
