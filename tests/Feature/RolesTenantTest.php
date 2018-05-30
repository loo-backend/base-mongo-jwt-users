<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class RolesTenantTest extends TestCase
{

    public function migrateAndFactory()
    {

        $this->restoreDatabase();

        factory(User::class)->create(['administrator' => User::REGULAR_USER]);

        Artisan::call('db:seed', [
            '--class'   => 'RoleTenantSeeder',
            '--force'   => true
        ]);

    }

    public function testRolesTenantAll()
    {

        $this->migrateAndFactory();

        $user = User::where('administrator', User::REGULAR_USER)->first();
        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $response = $this->get(route('roles.tenants.index'), $headers)
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
                'administrator' => User::REGULAR_USER,
                'default' => true
            ]
        ]);

    }


    public function testShowRolesTenant()
    {

        $this->migrateAndFactory();

        $user = User::where('administrator', User::REGULAR_USER)->first();
        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $role = Role::where('administrator', User::REGULAR_USER)->first();

        $response = $this->get(route('roles.tenants.show', $role->id ), $headers)
            ->assertStatus(200);

        $response->assertJson([

            'data' => [
                'data' => [
                    '_id' => $role->id,
                    'administrator' => User::REGULAR_USER,
                    'default' => true
                ]
            ]
        ]);

    }

}
