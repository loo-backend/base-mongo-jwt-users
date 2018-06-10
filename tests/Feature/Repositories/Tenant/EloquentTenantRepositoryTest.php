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

    protected function setUp()
    {
        parent::setUp();
        Schema::connection(env('DB_CONNECTION'))->drop('tenants');

        Artisan::call('migrate', [
            '--path' => "app/database/migrations",
            '--force'   => true
        ]);

    }

    /**
     * @throws \Exception
     */
    public function test_tenant_repository_create()
    {

        $repository = new EloquentTenantRepository(new Tenant());

        $faker = Factory::create();
        $data = [
            'companyName' =>  $faker->company,
        ];

        $repository->create( $data );

        $this->assertDatabaseHas('tenants', [
            'companyName' => $data['companyName'],
        ]);

    }

    /**
     * @throws \Exception
     */
    public function test_tenant_repository_find_by_id()
    {

        $repository = new EloquentTenantRepository(new Tenant());

        $faker = Factory::create();
        $data = [
            'companyName' =>  $faker->company,
        ];

        $obj = $repository->create( $data );

        $res = $repository->findById($obj->id);
        $this->assertEquals($obj->name, $res->name);

    }


    /**
     * @throws \Exception
     */
    public function test_tenant_repository_update()
    {

        $repository = new EloquentTenantRepository(new Tenant());

        $faker = Factory::create();
        $data = [
            'companyName' =>  $faker->company,
        ];

        $obj = $repository->create( $data );

        $data2 = [
            'companyName' =>  $faker->company,
        ];

        $repository->update($obj->id, $data2);

        $this->assertDatabaseMissing('tenants', [
            'companyName' => $data['companyName'],
        ]);

    }


    /**
     * @throws \Exception
     */
    public function test_tenant_repository_delete()
    {

        $repository = new EloquentTenantRepository(new Tenant());

        $faker = Factory::create();
        $data = [
            'companyName' =>  $faker->company,
        ];

        $obj = $repository->create( $data );

        $repository->delete($obj->id);
        $this->assertSoftDeleted('tenants', [
            'companyName' => $data['companyName'],
        ]);

    }

}
