<?php

namespace Tests\Feature;

use App\User;
use Faker\Factory;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsersAdminAuthApiTest extends TestCase
{

    public $data = [];
    public $content;

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

        $user = User::where('administrator', true)->first();
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
            'administrator' => User::ADMIN_USER
        ]);

    }

    public function testUserAuthenticateValid() {

        $this->faker();

        $user = User::where('administrator', User::ADMIN_USER)->first();
        $response = $this->post(route('authenticate'),
                ['email'=>  $user->email, 'password' => $this->data['password']])
            ->assertStatus(200);

        $response->assertJson(['data' => [
            'HTTP_Authorization' => true
        ]]);

    }

    public function testUserAuthenticateInvalid() {

        $user = User::where('administrator', true)->first();
        $response = $this->post(route('authenticate'),
                ['email'=>$user->email,'password' => str_random(6)])
            ->assertStatus(401);

        $response->assertJson(['error' => 'invalid_credentials']);
        $response->assertJson(['code' => 401]);

    }

}
