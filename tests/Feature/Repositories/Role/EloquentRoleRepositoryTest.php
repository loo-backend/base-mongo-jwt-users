<?php

namespace Tests\Feature\Repositories\Role;

use App\Entities\Role;
use App\Repositories\Role\RoleMongodbRepository;
use Faker\Factory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class RoleMongodbRepositoryTest extends TestCase
{

    protected $repository;

    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        parent::setUp();
        Schema::connection(env('DB_CONNECTION'))->drop('roles');

        Artisan::call('migrate', [
            '--path' => "app/database/migrations",
            '--force'   => true
        ]);

        $this->repository = new RoleMongodbRepository(new Role());

    }

    /**
     * @throws \Exception
     */
    public function test_user_repository_all()
    {

        Artisan::call('db:seed', [
            '--class'   => 'PrivilegeSeeder',
            '--force'   => true
        ]);

        Artisan::call('db:seed', [
            '--class'   => 'RoleAdminSeeder',
            '--force'   => true
        ]);

        $res = $this->repository->all();
        foreach ($res as $re) {
            $this->assertArrayHasKey('name', $re);
        }

    }

    /**
     * @throws \Exception
     */
    public function test_role_repository_create()
    {

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
        ];

        $this->repository->create( $data );

        $this->assertDatabaseHas('roles', [
            'name' => $data['name'],
        ]);

    }

    /**
     * @throws \Exception
     */
    public function test_role_repository_find_by_id()
    {

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
        ];

        $obj = $this->repository->create( $data );

        $res = $this->repository->findById($obj->id);
        $this->assertEquals($obj->name, $res->name);

    }


    /**
     * @throws \Exception
     */
    public function test_role_repository_update()
    {

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
        ];

        $obj = $this->repository->create( $data );

        $data2 = [
            'name' =>  $faker->name,
        ];

        $this->repository->update($obj->id, $data2);

        $this->assertDatabaseMissing('roles', [
            'name' => $data['name'],
        ]);

    }


    /**
     * @throws \Exception
     */
    public function test_role_repository_delete()
    {

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
        ];

        $obj = $this->repository->create( $data );

        $this->repository->delete($obj->id);
        $this->assertSoftDeleted('roles', [
            'name' => $data['name'],
        ]);

    }

    /**
     * @throws \Exception
     */
    public function test_role_repository_count()
    {

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
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
    public function test_role_repository_where_first()
    {

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->company,
        ];

        $this->repository->create( $data );
        $obj = $this->repository->whereFirst( $data );

        $this->assertEquals($obj->name, $data['name']);

    }

    /**
     * @throws \Exception
     */
    public function test_role_repository_where_exists()
    {

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
        ];

        $this->repository->create( $data );
        $exists = $this->repository->whereExists( $data );
        $this->assertTrue($exists);

    }

}
