<?php

namespace Tests\Feature\Repositories\User;

use Faker\Factory;
use App\Entities\User;
use App\Repositories\User\EloquentUserRepository;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class EloquentUserRepositoryTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();
        Schema::connection(env('DB_CONNECTION'))->drop('users');

        Artisan::call('migrate', [
            '--path' => "app/database/migrations",
            '--force'   => true
        ]);

    }

    /**
     * @throws \Exception
     */
    public function test_user_repository_create()
    {

        $repository = new EloquentUserRepository(new User());

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
            'email' => $faker->email,
            'password' => bcrypt('secret')
        ];

        $repository->create( $data );

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

    }

    /**
     * @throws \Exception
     */
    public function test_user_repository_find_by_id()
    {

        $repository = new EloquentUserRepository(new User());

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
            'email' => $faker->email,
            'password' => bcrypt('secret')
        ];

        $obj = $repository->create( $data );

        $res = $repository->findById($obj->id);
        $this->assertEquals($obj->name, $res->name);
        $this->assertEquals($data['email'], $res->email);

    }


    /**
     * @throws \Exception
     */
    public function test_user_repository_update()
    {

        $repository = new EloquentUserRepository(new User());

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
            'email' => $faker->email,
            'password' => bcrypt('secret')
        ];

        $obj = $repository->create( $data );

        $data2 = [
            'name' =>  $faker->name,
            'email' => $faker->email,
            'password' => bcrypt('secret')
        ];

        $repository->update($obj->id, $data2);

        $this->assertDatabaseMissing('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

    }


    /**
     * @throws \Exception
     */
    public function test_user_repository_delete()
    {

        $repository = new EloquentUserRepository(new User());

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
            'email' => $faker->email,
            'password' => bcrypt('secret')
        ];

        $obj = $repository->create( $data );

        $repository->delete($obj->id);

        $this->assertSoftDeleted('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

    }

}
