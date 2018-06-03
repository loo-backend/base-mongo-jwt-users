<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class RoleRegularTest extends TestCase
{

    public function migrateAndFactory()
    {

        //factory(User::class)->create(['is_admin' => User::ADMIN_USER]);

        Artisan::call('db:seed', [
            '--class'   => 'RoleRegularSeeder',
            '--force'   => true
        ]);

    }

    public function testRolesAdminAll()
    {
        $this->migrateAndFactory();
        $response = $this->get('/');
        $response->assertStatus(200);

    }

}
