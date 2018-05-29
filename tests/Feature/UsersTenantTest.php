<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Tymon\JWTAuth\Facades\JWTAuth;


class UsersTenantTest extends TestCase
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
            'administrator' => User::REGULAR_USER,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

    }

    public function migrateAndFactory()
    {

        $this->faker();

        Artisan::call('migrate', [
            '--path' => "app/database/migrations"
        ]);

        $users = factory(User::class)->create();
        $users->roles()->create(Role::TENANT_ADMINISTRATOR);

    }

    public function testUserCreate()
    {

        $this->migrateAndFactory();

        $data = $this->data;
        $data['roles'] = Role::TENANT_ADMINISTRATOR;


        $user = User::where('administrator', User::REGULAR_USER)->first();
        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $response = $this->post('/users/tenants', $data, $headers)
            ->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
            'administrator' => User::REGULAR_USER,
        ]);

        $response->assertJsonStructure([
            'data' => [
                'HTTP_Authorization'
            ]
        ]);

    }

    public function testShowUser()
    {

        $user = User::where('administrator', User::REGULAR_USER)->first();
        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $response = $this->get('/users/tenants/'. $user->id, $headers)
            ->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [

                '*' => [
                    '_id',
                    'user_uuid',
                    'name',
                    'email',
                    'active',
                    'administrator',
                    // 'roles' => [
                    //     '*' => [
                    //         'name', 'permissions'
                    //     ]
                    // ]

                ]

            ]

        ]);

        // $response->assertJson([
        //     'data' => [
        //         'data' => [
        //             'administrator' => User::ADMIN_USER,
        //         ]
        //     ]
        // ]);


    }

    public function testAllUsersTenants()
    {

        $user = User::where('administrator', User::REGULAR_USER)->first();
        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $response = $this->get('/users/tenants', $headers)
            ->assertStatus(200);




        $response->assertJsonStructure([
            'data' => [

                '*' => [

                    '_id',
                    'user_uuid',
                    'name',
                    'email',
                    'active',
                    'administrator',
                    // 'roles' => [
                    //     '*' => [
                    //         'name', 'permissions'
                    //     ]
                    // ]

                ]

            ]

        ]);


        $response->assertJson([
            'data' => [
                ['administrator' => User::REGULAR_USER]
            ]
        ]);

    }

    public function testUpdateUserNoPassword()
    {

        $user = User::where('administrator', User::REGULAR_USER)->first();

        $data = [
            'name' => str_random(12),
            'email' => $user->email
        ];

        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $this->put('/users/tenants/'.$user->id, $data, $headers)
            ->assertStatus(200);

        $this->assertDatabaseMissing('users',[
            '_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'administrator' => User::REGULAR_USER
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

        $user = User::where('administrator', User::REGULAR_USER)->first();
        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $this->put('/users/tenants/'.$user->id, $data, $headers)
            ->assertStatus(200);

         $this->assertDatabaseMissing('users',[
            '_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'administrator' => User::REGULAR_USER
        ]);

    }

//    public function testDeleteUser()
//    {
//
//        $user = User::first();
//        $token = JWTAuth::fromUser($user);
//
//        $response = $this->withHeaders([
//            'HTTP_Authorization' => 'Bearer '. $token,
//        ])->json('DELETE', '/users/tenants/'.$user->id);
//
//        $response->assertStatus(200)
//            ->assertExactJson([
//                'data' => 'user_removed'
//            ]);
//
//
//        $users = User::all();
//
//        foreach ($users as $user) {
//            User::find($user->id)->forceDelete();
//        }
//
//
//    }

}
