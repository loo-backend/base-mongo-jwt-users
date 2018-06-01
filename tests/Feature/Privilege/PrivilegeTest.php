<?php

namespace Tests\Feature;

use App\Privilege;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class PrivilegeTest extends TestCase
{

    public function migrateAndFactory()
    {

        factory(User::class)->create(['administrator' => User::REGULAR_USER]);

        Artisan::call('db:seed', [
            '--class'   => 'PrivilegeSeeder',
            '--force'   => true
        ]);

    }

    public function testRolePrivilegeAll()
    {

        $this->migrateAndFactory();

        $user = User::where('administrator', User::REGULAR_USER)->first();
        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $response = $this->get(route('privileges.index'), $headers)
            ->assertStatus(200);

        $response->assertJsonStructure([
            '*' => [
                'name',
                'description',
                'privilege_uuid',
            ]

        ]);

    }

    public function testShowRolePrivilege()
    {

        $this->migrateAndFactory();

        $user = User::where('administrator', User::REGULAR_USER)->first();
        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $privilege = Privilege::first();

        $response = $this->get(route('privileges.show', $privilege->id ), $headers)
            ->assertStatus(200);

        $response->assertJson([
            'data' => [
                'name' => $privilege->name,
                'description' => $privilege->description,
                'privilege_uuid' => $privilege->privilege_uuid,
            ]
        ]);

    }

}
