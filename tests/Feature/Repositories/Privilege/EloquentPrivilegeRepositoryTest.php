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

    protected function setUp()
    {
        parent::setUp();
        Schema::connection(env('DB_CONNECTION'))->drop('privileges');

        Artisan::call('migrate', [
            '--path' => "app/database/migrations",
            '--force'   => true
        ]);

    }

    /**
     * @throws \Exception
     */
    public function test_privilege_repository_create()
    {

        $repository = new EloquentPrivilegeRepository(new Privilege());

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
        ];

        $repository->create( $data );

        $this->assertDatabaseHas('privileges', [
            'name' => $data['name'],
        ]);

    }

    /**
     * @throws \Exception
     */
    public function test_privilege_repository_find_by_id()
    {

        $repository = new EloquentPrivilegeRepository(new Privilege());

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
    public function test_privilege_repository_update()
    {

        $repository = new EloquentPrivilegeRepository(new Privilege());

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
        ];

        $obj = $repository->create( $data );

        $data2 = [
            'name' =>  $faker->name,
        ];

        $repository->update($obj->id, $data2);

        $this->assertDatabaseMissing('privileges', [
            'name' => $data['name'],
        ]);

    }


    /**
     * @throws \Exception
     */
    public function test_privilege_repository_delete()
    {

        $repository = new EloquentPrivilegeRepository(new Privilege());

        $faker = Factory::create();
        $data = [
            'name' =>  $faker->name,
        ];

        $obj = $repository->create( $data );
        
        $repository->delete($obj->id);
        $this->assertSoftDeleted('privileges', [
            'name' => $data['name'],
        ]);

    }

}
