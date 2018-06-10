<?php

namespace Tests\Feature\Repositories\Tenant;

use App\Entities\Tenant;
use App\Repositories\Tenant\EloquentTenantRepository;
use Faker\Factory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class EloquentTenantRepositoryTest extends TestCase
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

        $this->repository = new EloquentTenantRepository(new Tenant());

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

}
