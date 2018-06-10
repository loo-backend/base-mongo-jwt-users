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

    protected $repository;

    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        parent::setUp();
        Schema::connection(env('DB_CONNECTION'))->drop('users');

        Artisan::call('migrate', [
            '--path' => "app/database/migrations",
            '--force'   => true
        ]);

        $this->repository = new EloquentUserRepository(new User());

    }


     /**
     * @throws \Exception
     */
    public function test_user_repository_all()
    {

        factory(User::class, 10)->create();
        $res = $this->repository->all([], 2);
        foreach ($res as $re) {
            $this->assertArrayHasKey('userUuid', $re);
        }

    }

    /**
     * @throws \Exception
     */
    public function test_user_repository_create()
    {

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
            'email' => $faker->email,
            'password' => bcrypt('secret')
        ];

        $this->repository->create( $data );

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

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
            'email' => $faker->email,
            'password' => bcrypt('secret')
        ];

        $obj = $this->repository->create( $data );

        $res = $this->repository->findById($obj->id);
        $this->assertEquals($obj->name, $res->name);
        $this->assertEquals($data['email'], $res->email);

    }


    /**
     * @throws \Exception
     */
    public function test_user_repository_update()
    {

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
            'email' => $faker->email,
            'password' => bcrypt('secret')
        ];

        $obj = $this->repository->create( $data );

        $data2 = [
            'name' =>  $faker->name,
            'email' => $faker->email,
            'password' => bcrypt('secret')
        ];

        $this->repository->update($obj->id, $data2);

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

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
            'email' => $faker->email,
            'password' => bcrypt('secret')
        ];

        $obj = $this->repository->create( $data );

        $this->repository->delete($obj->id);

        $this->assertSoftDeleted('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

    }

    /**
     * @throws \Exception
     */
    public function test_user_repository_count()
    {

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
            'email' => $faker->email,
            'password' => bcrypt('secret')
        ];

        $this->repository->create( $data );
        $res = $this->repository->count( $data );

        if($res  > 0) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }

    }

    /**
     * @throws \Exception
     */
    public function test_user_repository_where_first()
    {

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
            'email' => $faker->email
        ];

        $this->repository->create( $data );
        $obj = $this->repository->whereFirst( $data );

        $this->assertEquals($obj->name, $data['name']);
        $this->assertEquals($obj->email, $data['email']);

    }

    /**
     * @throws \Exception
     */
    public function test_user_repository_where_exists()
    {

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
            'email' => $faker->email
        ];

        $this->repository->create( $data );
        $exists = $this->repository->whereExists( $data );
        $this->assertTrue($exists);

    }

}
