<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class RolesAdminTest extends TestCase
{


    public function migrateAndFactory()
    {

        $this->restoreDatabase();

        factory(User::class)->create(['administrator' => User::ADMIN_USER]);

        Artisan::call('db:seed', [
            '--class'   => 'RoleAdminSeeder',
            '--force'   => true
        ]);

    }


    public function testsRolesAdminAll()
    {

        $this->migrateAndFactory();

        $user = User::where('administrator', true)->first();
        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $response = $this->get('/roles/admins', $headers)
            ->assertStatus(200);


        $response->assertJsonStructure([
            '*' => [
                '_id',
                'name',
                'description',
                'administrator',
                'role_uuid',
                'default'
            ]

        ]);

        $response->assertJson([
            [
                'administrator' => User::ADMIN_USER,
                'default' => true
            ]
        ]);

    }

}
