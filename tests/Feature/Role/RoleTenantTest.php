<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoleTenantTest extends TestCase
{

    public function migrateAndFactory()
    {

        factory(User::class)->create(['is_tenant' => User::TENANT_USER]);

        Artisan::call('db:seed', [
            '--class'   => 'RoleTenantSeeder',
            '--force'   => true
        ]);

    }

    public function testRolesTenantAll()
    {

        $this->migrateAndFactory();

        $user = User::where('is_tenant', User::TENANT_USER)->first();
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
                'role_uuid',
                'default',
                'privileges'
            ]

        ]);

        $response->assertJson([
            [
                'name' => Role::TENANT_ADMIN,
                'default' => true
            ]
        ]);

    }


    public function testShowRolesTenant()
    {

        $this->migrateAndFactory();

        $user = User::where('is_tenant', User::TENANT_USER)->first();
        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $role = Role::whereIn('name', [

            Role::TENANT_ADMIN

        ])->first();


        $response = $this->get(route('roles.tenants.show', $role->id ), $headers)
            ->assertStatus(200);

        $response->assertJson([
            'data' => [
                '_id' => $role->id,
                'name' => Role::TENANT_ADMIN,
                'default' => true
            ]
        ]);

    }

}
