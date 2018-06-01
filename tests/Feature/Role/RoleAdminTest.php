<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoleAdminTest extends TestCase
{

    public function migrateAndFactory()
    {

        factory(User::class)->create(['is_admin' => User::ADMIN_USER]);

        Artisan::call('db:seed', [
            '--class'   => 'RoleAdminSeeder',
            '--force'   => true
        ]);

    }

    public function testRolesAdminAll()
    {

        $this->migrateAndFactory();

        $user = User::where('is_admin', User::ADMIN_USER)->first();
        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $response = $this->get(route('roles.admins.index'), $headers)
            ->assertStatus(200);

        $response->assertJsonStructure([
            '*' => [
                '_id',
                'name',
                'description',
                'role_uuid',
                'default',
                'privileges'
            ]

        ]);

        $response->assertJson([
            [
                'default' => true
            ]
        ]);

    }


    public function testShowRolesAdmin()
    {

        $this->migrateAndFactory();

        $user = User::where('is_admin', User::ADMIN_USER)->first();
        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $role = Role::whereIn('name', [
            Role::ADMIN
        ])->first();

        $response = $this->get(route('roles.admins.show', $role->id), $headers)
            ->assertStatus(200);

        $response->assertJson([
            'data' => [
                '_id' => $role->id,
                'name' => Role::ADMIN,
                'default' => true
            ]
        ]);

    }

}
