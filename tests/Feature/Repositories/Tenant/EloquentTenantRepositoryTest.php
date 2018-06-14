<?php

namespace Tests\Feature\Repositories\Tenant;

use App\Entities\Tenant;
use App\Repositories\Tenant\TenantMongodbRepository;
use Faker\Factory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TenantMongodbRepositoryTest extends TestCase
{

    protected $repository;

    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        parent::setUp();
        Schema::connection(env('DB_CONNECTION'))->drop('tenants');

        Artisan::call('migrate', [
            '--path' => "app/database/migrations",
            '--force'   => true
        ]);

        $this->repository = new TenantMongodbRepository(new Tenant());

    }

    /**
     * @throws \Exception
     */
    public function test_role_repository_all()
    {

        factory(Tenant::class, 10)->create();
        $res = $this->repository->all([], 2);
        foreach ($res as $re) {
            $this->assertArrayHasKey('companyName', $re);
        }

    }


    /**
     * @throws \Exception
     */
    public function test_tenant_repository_create()
    {

        $faker = Factory::create();
        $data = [
            'companyName' =>  $faker->company,
        ];

        $this->repository->create( $data );

        $this->assertDatabaseHas('tenants', [
            'companyName' => $data['companyName'],
        ]);

    }

    /**
     * @throws \Exception
     */
    public function test_tenant_repository_find_by_id()
    {

        $faker = Factory::create();
        $data = [
            'companyName' =>  $faker->company,
        ];

        $obj = $this->repository->create( $data );

        $res = $this->repository->findById($obj->id);
        $this->assertEquals($obj->name, $res->name);

    }


    /**
     * @throws \Exception
     */
    public function test_tenant_repository_update()
    {

        $faker = Factory::create();
        $data = [
            'companyName' =>  $faker->company,
        ];

        $obj = $this->repository->create( $data );

        $data2 = [
            'companyName' =>  $faker->company,
        ];

        $this->repository->update($obj->id, $data2);

        $this->assertDatabaseMissing('tenants', [
            'companyName' => $data['companyName'],
        ]);

    }


    /**
     * @throws \Exception
     */
    public function test_tenant_repository_delete()
    {

        $faker = Factory::create();
        $data = [
            'companyName' =>  $faker->company,
        ];

        $obj = $this->repository->create( $data );

        $this->repository->delete($obj->id);
        $this->assertSoftDeleted('tenants', [
            'companyName' => $data['companyName'],
        ]);

    }


    /**
     * @throws \Exception
     */
    public function test_tenant_repository_count()
    {

        $faker = Factory::create();
        $data = [
            'companyName' =>  $faker->company,
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
    public function test_tenant_repository_where_first()
    {

        $faker = Factory::create();
        $data = [
            'companyName' =>  $faker->company,
        ];

        $this->repository->create( $data );
        $obj = $this->repository->whereFirst( $data );

        $this->assertEquals($obj->companyName, $data['companyName']);

    }

    /**
     * @throws \Exception
     */
    public function test_tenant_repository_where_exists()
    {

        $faker = Factory::create();
        $data = [
            'companyName' =>  $faker->company,
        ];

        $this->repository->create( $data );
        $exists = $this->repository->whereExists( $data );
        $this->assertTrue($exists);

    }

}
