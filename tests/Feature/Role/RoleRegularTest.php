<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\RestoreDatabaseTrait;
use Tests\TestCase;

class RoleRegularTest extends TestCase
{

    use RestoreDatabaseTrait;

    // protected function setUp()
    // {
    //     parent::setUp(); // TODO: Change the autogenerated stub

    //     Artisan::call('db:seed', [
    //         '--class'   => 'DatabaseSeeder',
    //         '--force'   => true
    //     ]);

    // }

    public function testRolesAdminAll()
    {
        $this->assertTrue(true);

    }

    // public function testRestoreDatabase()
    // {
    //     $this->restoreDatabase();
    //     $this->assertTrue(true);
    // }

}
