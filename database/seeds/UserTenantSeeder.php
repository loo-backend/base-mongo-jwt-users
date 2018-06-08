<?php

use App\Entities\Role;
use App\Entities\Tenant;
use App\Entities\User;
use Illuminate\Database\Seeder;

class UserTenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $tenants = Tenant::all();
        $tenants->each(function ($tenant) {


            $this->generateUser($tenant, Role::TENANT_ADMIN);

            if(rand(0,1)===1) {
                $this->generateUser($tenant, Role::TENANT_EDITOR);
            }

            if ($tenant->limitUser > 2) {

                $this->generateUser($tenant, Role::TENANT_ADMIN);
                $this->generateUser($tenant, Role::TENANT_PARTNER);

                if(rand(0,1)===1) {
                    $this->generateUser($tenant, Role::TENANT_EXPEDITION);
                }
            }

            if ($tenant->limitUser > 4) {
                $this->generateUser($tenant, Role::TENANT_ADMIN);
            }

        });

    }


    private function generateUser($tenant, $typeTenant)
    {

        $users = factory(User::class,rand(1,5))->create();

        $users->each(function ($user) use ($tenant, $typeTenant) {

            $roleFirst = Role::where('name', $typeTenant)->first();

            $role = $user->roles()->create([
                'name' => $roleFirst->name,
                'roleUuid' => $roleFirst->uuid,
            ]);

            $rolesAll = Role::where('name', $typeTenant)->get();

            foreach ($rolesAll as $item) {

                foreach ($item->privileges as $privilege) {

                    $user->privileges()->create([
                        'roleId' => $role->id,
                        'roleUuid' => $roleFirst->uuid,
                        'name' => $privilege->name
                    ]);

                }

            }

            $user->tenants()->create([
                'tenantId' => $tenant->id,
                'tenantUuid' => $tenant->uuid,
                'roleUuid' => $roleFirst->uuid
            ]);

        });

    }

}
