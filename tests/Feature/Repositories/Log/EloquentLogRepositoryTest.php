<?php

namespace Tests\Feature\Repositories\Log;

use App\Entities\Log;
use App\Repositories\Log\EloquentLogRepository;
use Faker\Factory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class EloquentLogRepositoryTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();
        Schema::connection(env('DB_CONNECTION'))->drop('logs');

        Artisan::call('migrate', [
            '--path' => "app/database/migrations",
            '--force'   => true
        ]);

    }

    /**
     * @throws \Exception
     */
    public function test_log_repository_create()
    {

        $repository = new EloquentLogRepository(new Log());

        $faker = Factory::create();
        $data = [
            'action' =>  $faker->name,
        ];

        $res = $repository->create( $data );

        $this->assertEquals($data['action'], $res->action);

    }

    /**
     * @throws \Exception
     */
    public function test_log_repository_find_by_id()
    {

        $repository = new EloquentLogRepository(new Log());

        $faker = Factory::create();
        $data = [
            'action' =>  $faker->name,
        ];

        $obj = $repository->create( $data );

        $res = $repository->findById($obj->id);
        $this->assertEquals($obj->name, $res->name);

    }


    /**
     * @throws \Exception
     */
    public function test_log_repository_update()
    {

        $repository = new EloquentLogRepository(new Log());

        $faker = Factory::create();
        $data = [
            'action' =>  $faker->name,
        ];

        $obj = $repository->create( $data );

        $data2 = [
            'action' =>  $faker->name,
        ];

        $repository->update($obj->id, $data2);

        $this->assertDatabaseMissing('logs', [
            'action' => $data['action'],
        ]);

    }


    /**
     * @throws \Exception
     */
    public function test_log_repository_delete()
    {

        $repository = new EloquentLogRepository(new Log());

        $faker = Factory::create();
        $data = [
            'action' =>  $faker->name,
        ];

        $obj = $repository->create( $data );

        $res = $repository->delete($obj->id);

        $this->assertTrue($res);

    }

}
