<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Faker\Factory;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserAdminTest extends TestCase
{

    public $data = [];

    public function __construct(string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    public function faker()
    {

        $faker = Factory::create();

        $this->data = [
            'name' => $faker->name,
            'email' => $faker->email,
            'active' => true,
            'administrator' => User::ADMIN_USER,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

    }

    public function migrateAndFactory()
    {

        $this->restoreDatabase();
        $this->faker();

        factory(User::class)->create(['administrator' => User::ADMIN_USER]);

    }

    public function testUserCreate()
    {

        $this->migrateAndFactory();

        $data = $this->data;
        $data['roles'] = Role::ADMINISTRATOR;

        $user = User::where('administrator', User::ADMIN_USER)->first();
        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $response = $this->post(route('users.admins.store'), $data, $headers)
            ->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
            'administrator' => User::ADMIN_USER
        ]);

        $response->assertJsonStructure([
            'data' => [
                'HTTP_Authorization'
            ]
        ]);

    }

    public function testShowUser()
    {

        $user = User::where('administrator', User::ADMIN_USER)->first();
        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $response = $this->get(route('users.admins.show', $user->id), $headers)
            ->assertStatus(200);

        $response->assertJson([
            'data' => [
                '_id' => $user->id,
                'user_uuid' => $user->user_uuid,
                'name' => $user->name,
                'email' => $user->email,
                'administrator' => User::ADMIN_USER
            ]
        ]);

    }

    public function testAllUsers()
    {

        $user = User::where('administrator', User::ADMIN_USER)->first();
        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $response = $this->get(route('users.admins.index'), $headers)
            ->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [

                '*' => [
                    '_id',
                    'user_uuid',
                    'name',
                    'email',
                    'active',
                    'administrator'
                ]

            ]

        ]);

        $response->assertJson([
            'data' => [
                ['administrator' => User::ADMIN_USER]
            ]
        ]);

    }

    public function testUpdateUserNoPassword()
    {

        $user = User::where('administrator', User::ADMIN_USER)->first();

        $data = [
            'name' => str_random(12),
            'email' => $user->email
        ];

        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $this->put(route('users.admins.update',$user->id), $data, $headers)
            ->assertStatus(200);

        $this->assertDatabaseMissing('users',[
            'name' => $user->name,
            'email' => $user->email,
            '_id' => $user->id
        ]);

    }

    public function testUpdateUserWithPassword()
    {

        $data = [
            'name' => str_random(12),
            'email' => str_random(7) . '@mail.com',
            'password' => 123456,
            'password_confirmation' => 123456
        ];

        $user = User::where('administrator', User::ADMIN_USER)->first();
        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $this->put(route('users.admins.update',$user->id), $data, $headers)
            ->assertStatus(200);

        $this->assertDatabaseMissing('users', [
            'name' => $user->name,
            'email' => $user->email,
            '_id' => $user->id
        ]);

    }


    public function testDeleteUser()
    {

        $user = User::where('administrator',  User::ADMIN_USER)->first();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'HTTP_Authorization' => 'Bearer '. $token,
        ])->json('DELETE', route('users.admins.destroy', $user->id));

        $response->assertStatus(200)
            ->assertExactJson([
                'data' => 'user_removed'
            ]);


    }

}