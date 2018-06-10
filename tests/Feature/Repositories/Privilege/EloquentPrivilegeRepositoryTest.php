<?php

namespace Tests\Feature\Repositories\Privilege;

use App\Entities\Privilege;
use App\Repositories\Privilege\EloquentPrivilegeRepository;
use Faker\Factory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class EloquentPrivilegeRepositoryTest extends TestCase
{

    protected $repository;

    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        parent::setUp();
        Schema::connection(env('DB_CONNECTION'))->drop('privileges');

        Artisan::call('migrate', [
            '--path' => "app/database/migrations",
            '--force'   => true
        ]);

        $this->repository = new EloquentPrivilegeRepository(new Privilege());

    }

    /**
     * @throws \Exception
     */
    public function test_privilege_repository_all()
    {

        Artisan::call('db:seed', [
            '--class'   => 'PrivilegeSeeder',
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
    public function test_privilege_repository_create()
    {

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
        ];

        $this->repository->create( $data );

        $this->assertDatabaseHas('privileges', [
            'name' => $data['name'],
        ]);

    }

    /**
     * @throws \Exception
     */
    public function test_privilege_repository_find_by_id()
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
    public function test_privilege_repository_update()
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

        $this->assertDatabaseMissing('privileges', [
            'name' => $data['name'],
        ]);

    }


    /**
     * @throws \Exception
     */
    public function test_privilege_repository_delete()
    {

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
        ];

        $obj = $this->repository->create( $data );

        $this->repository->delete($obj->id);
        $this->assertSoftDeleted('privileges', [
            'name' => $data['name'],
        ]);

    }


    /**
     * @throws \Exception
     */
    public function test_privilege_repository_count()
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

}
