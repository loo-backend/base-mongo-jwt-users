<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsersAdminTest extends TestCase
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

        $this->faker();

        Artisan::call('migrate', [
            '--path' => "app/database/migrations"
        ]);

        $users = factory(User::class)->create(['administrator' => User::ADMIN_USER]);
        $users->roles()->create(Role::ADMINISTRATOR);

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

        $response = $this->post('/users/admins', $data, $headers)
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

        $response = $this->get('/users/admins/'. $user->id, $headers)
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


    }

    public function testAllUsers()
    {

        $user = User::where('administrator', User::ADMIN_USER)->first();
        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $response = $this->get('/users/admins', $headers)
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

        $this->put('/users/admins/'.$user->id, $data, $headers)
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

        $this->put('/users/admins/'.$user->id, $data, $headers)
            ->assertStatus(200);

        $this->assertDatabaseMissing('users', [
            'name' => $user->name,
            'email' => $user->email,
            '_id' => $user->id
        ]);

    }

//    public function testAddRolesStaffSupport()
//    {
//
//        $user = User::where('administrator', true)->first();
//
//        $token = JWTAuth::fromUser($user);
//
//        $headers = [
//            'Accept' => 'application/vnd.laravel.v1+json',
//            'HTTP_Authorization' => 'Bearer ' . $token
//        ];
//
//        $this->put('/users/admins/'.$user->id, $this->roles_staff_support, $headers)
//            ->assertStatus(200);
//
//    }

    /**
     *
     */
    public function testDeleteUser()
    {

        $user = User::where('administrator',  User::ADMIN_USER)->first();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'HTTP_Authorization' => 'Bearer '. $token,
        ])->json('DELETE', '/users/admins/'.$user->id);

        $response->assertStatus(200)
            ->assertExactJson([
                'data' => 'user_removed'
            ]);


//        $users = User::all();
//
//        foreach ($users as $user) {
//            User::find($user->id)->forceDelete();
//        }


    }

}
