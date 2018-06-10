<?php

namespace Tests\Feature\Repositories\Role;

use App\Entities\Role;
use App\Repositories\Role\EloquentRoleRepository;
use Faker\Factory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class EloquentRoleRepositoryTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();
        Schema::connection(env('DB_CONNECTION'))->drop('roles');

        Artisan::call('migrate', [
            '--path' => "app/database/migrations",
            '--force'   => true
        ]);

    }

    /**
     * @throws \Exception
     */
    public function test_role_repository_create()
    {

        $repository = new EloquentRoleRepository(new Role());

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
        ];

        $repository->create( $data );

        $this->assertDatabaseHas('roles', [
            'name' => $data['name'],
        ]);

    }

    /**
     * @throws \Exception
     */
    public function test_role_repository_find_by_id()
    {

        $repository = new EloquentRoleRepository(new Role());

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
        ];

        $obj = $repository->create( $data );

        $res = $repository->findById($obj->id);
        $this->assertEquals($obj->name, $res->name);

    }


    /**
     * @throws \Exception
     */
    public function test_role_repository_update()
    {

        $repository = new EloquentRoleRepository(new Role());

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
        ];

        $obj = $repository->create( $data );

        $data2 = [
            'name' =>  $faker->name,
        ];

        $repository->update($obj->id, $data2);

        $this->assertDatabaseMissing('roles', [
            'name' => $data['name'],
        ]);

    }


    /**
     * @throws \Exception
     */
    public function test_role_repository_delete()
    {

        $repository = new EloquentRoleRepository(new Role());

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
        ];

        $obj = $repository->create( $data );

        $repository->delete($obj->id);
        $this->assertSoftDeleted('roles', [
            'name' => $data['name'],
        ]);

    }

}
