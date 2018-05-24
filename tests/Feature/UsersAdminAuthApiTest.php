<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UsersAdminAuthApiTest extends TestCase
{


    public $data = [];
    public $content;

    public function __construct(string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->data = [
            'name' => str_random(10),
            'email' => str_random(6) . '@mail.com',
            'active' => true,
            'is_administrator' => true,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

    }

    public function migrateAndFactory()
    {
        Artisan::call('migrate', [
            '--path' => "app/database/migrations"
        ]);

        $users = factory(User::class)->create(['is_administrator' => User::ADMINISTRATOR]);
        $users->roles()->create(Role::ADMINISTRATOR);

    }


    public function testUserCreate()
    {

        $this->migrateAndFactory();

        $user = User::where('is_administrator', true)->first();
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        $this->post('/users/admins', $this->data, $headers)
                ->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => $this->data['name'],
            'email' => $this->data['email']
        ]);

    }


    public function testUserAuthenticateValid() {

        $user = User::where('is_administrator', User::ADMINISTRATOR)->first();
        $response = $this->post('/auth/authenticate',
                ['email'=>  $user->email, 'password' => $this->data['password']])
            ->assertStatus(200);

        $response->assertJson(['success' => true]);
        $response->assertJson(['HTTP_Authorization' => true]);

    }


    public function testUserAuthenticateInvalid() {

        $user = User::where('is_administrator', true)->first();
        $response = $this->post('/auth/authenticate',
                ['email'=>$user->email,'password' => str_random(6)])
            ->assertStatus(401);

        $response->assertJson(['success' => false]);
        $response->assertJson(['error' => 'invalid_credentials']);

    }


}
