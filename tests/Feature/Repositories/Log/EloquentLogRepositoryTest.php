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

    protected $repository;

    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        parent::setUp();
        Schema::connection(env('DB_CONNECTION_LOG'))->drop('logs');

        Artisan::call('migrate', [
            '--path' => "app/database/migrations",
            '--force'   => true
        ]);

        $this->repository = new EloquentLogRepository(new Log());

    }

    /**
     * @throws \Exception
     */
    public function test_log_repository_all()
    {

        factory(Log::class, 5)->create();

        $response = $this->repository->all();

        foreach ($response as $item) {
            $this->assertArrayHasKey('action', $item);
        }

    }

    /**
     * @throws \Exception
     */
    public function test_log_repository_create()
    {

        $faker = Factory::create();
        $data = [
            'action' =>  $faker->name,
        ];

        $res = $this->repository->create( $data );

        $this->assertEquals($data['action'], $res->action);

    }

    /**
     * @throws \Exception
     */
    public function test_log_repository_find_by_id()
    {

        $faker = Factory::create();
        $data = [
            'action' =>  $faker->name,
        ];

        $obj = $this->repository->create( $data );

        $res = $this->repository->findById($obj->id);
        $this->assertEquals($obj->name, $res->name);

    }


    /**
     * @throws \Exception
     */
    public function test_log_repository_update()
    {

        $faker = Factory::create();
        $data = [
            'action' =>  $faker->name,
        ];

        $obj = $this->repository->create( $data );

        $data2 = [
            'action' =>  $faker->name,
        ];

        $this->repository->update($obj->id, $data2);

        $this->assertDatabaseMissing('logs', [
            'action' => $data['action'],
        ]);

    }


    /**
     * @throws \Exception
     */
    public function test_log_repository_delete()
    {

        $faker = Factory::create();
        $data = [
            'action' =>  $faker->name,
        ];

        $obj = $this->repository->create( $data );

        $res = $this->repository->delete($obj->id);

        $this->assertTrue($res);

    }

    /**
     * @throws \Exception
     */
    public function test_log_repository_count()
    {

        factory(Log::class, 5)->create();
        $res = $this->repository->count(null);

        if($res  > 0) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }

    }


    /**
     * @throws \Exception
     */
    public function test_log_repository_where_first()
    {

        $faker = Factory::create();
        $data = [
            'action' =>  $faker->name,
        ];

        $this->repository->create( $data );
        $obj = $this->repository->whereFirst( $data );

        $this->assertEquals($obj->action, $data['action']);

    }

    /**
     * @throws \Exception
     */
    public function test_log_repository_where_exists()
    {

        $faker = Factory::create();
        $data = [
            'action' =>  $faker->name,
        ];

        $this->repository->create( $data );
        $exists = $this->repository->whereExists( $data );
        $this->assertTrue($exists);

    }


}
