<?php

namespace Tests\Feature;

use App\User;
use Faker\Factory;
use Illuminate\Support\Facades\Artisan;
use Tests\RestoreDatabaseTrait;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticateUserTest extends TestCase
{

    use RestoreDatabaseTrait;

    public $data = [];

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        Artisan::call('db:seed', [
            '--class'   => 'DatabaseSeeder',
            '--force'   => true
        ]);

        $faker = Factory::create();

        $this->data = [
            'name' => $faker->name,
            'email' => $faker->email,
            'active' => true,
            'isAdmin' => User::ADMIN_USER,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

    }

    public function testUserCreate()
    {

        $user = User::where('isAdmin', true)->first();
        $token = JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $this->post(route('users.admins.store'), $this->data, $headers)
                ->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'isAdmin' => User::ADMIN_USER
        ]);

    }

    public function testUserAuthenticateValid() {


        $user = User::where('isAdmin', User::ADMIN_USER)->first();

        $response = $this->post(route('auth.login'),
                ['email'=>  $user->email, 'password' => $this->data['password']])
            ->assertStatus(200);

        $response->assertJson(['data' => [
            'HTTP_Authorization' => true
        ]]);

        $json = json_decode( $response->content() );
        JWTAuth::setToken($json->data->HTTP_Authorization);

        $token = JWTAuth::getToken();
        $decode = JWTAuth::decode($token);

        $data = $decode->get('sub');
        $this->assertEquals($data->email, $user->email);

    }

    public function testUserAuthenticateInvalid() {

        $user = User::where('isAdmin', true)->first();
        $response = $this->post(route('auth.login'),
                ['email'=>$user->email,'password' => str_random(6)])
            ->assertStatus(401);

        $response->assertJson(['error' => 'invalid_credentials']);
        $response->assertJson(['code' => 401]);

    }

    public function testRestoreDatabase()
    {
        $this->restoreDatabase();
        $this->assertTrue(true);
    }

}
