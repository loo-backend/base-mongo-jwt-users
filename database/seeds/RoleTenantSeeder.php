<?php

use App\Entities\Privilege;
use App\Entities\User;
use Illuminate\Database\Seeder;
use App\Entities\Role;
use Webpatser\Uuid\Uuid;

class RoleTenantSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @throws Exception
     */
    public function run()
    {

        foreach ($this->dataRoles() as $data) {

            if (Role::where('name', $data['name'])->count() <= 0) {
                $this->createRoles($data);
            }

        }

    }

    /**
     * @param $data
     * @throws Exception
     */
    private function createRoles($data) {

        $role = Role::create([
            'uuid' => Uuid::generate(4)->string,
            'name' => $data['name'],
            'description' => $data['description'],
            'default' => true
        ]);

        if( $data['name'] === Role::TENANT_ADMIN ) {

            $all = Privilege::where('name', Privilege::ALL)->first();

            $role->privileges()->create([
                'uuid' => $all->uuid,
                'name' => $all->name,
                'description' => $all->description,
            ]);

        } else {

            $browser = Privilege::where('name', Privilege::BROWSER)->first();
            $read    = Privilege::where('name', Privilege::READ)->first();
            $add     = Privilege::where('name', Privilege::ADD)->first();
            $edit    = Privilege::where('name', Privilege::EDIT)->first();
            $delete  = Privilege::where('name', Privilege::DELETE)->first();

            $role->privileges()->create([
                'uuid' => $browser->uuid,
                'name' => $browser->name,
                'description' => $browser->description,
            ]);

            $role->privileges()->create([
                'uuid' => $read->uuid,
                'name' => $read->name,
                'description' => $read->description,
            ]);

            if ($data['name'] !== Role::ADMIN_STAFF_INITIAL) {

                $role->privileges()->create([
                    'uuid' => $add->uuid,
                    'name' => $add->name,
                    'description' => $add->description,
                ]);

                $role->privileges()->create([
                    'uuid' => $edit->uuid,
                    'name' => $edit->name,
                    'description' => $edit->description,
                ]);

            }

            if ($data['name'] !== Role::TENANT_EXPEDITION) {

                $role->privileges()->create([
                    'uuid' => $delete->uuid,
                    'name' => $delete->name,
                    'description' => $delete->description,
                ]);

            }

        }

    }

    public function dataRoles()
    {
        return [
            [
                'name' => Role::TENANT_ADMIN,
                'description' => 'Administrador',
            ],
            [
                'name' => Role::TENANT_EDITOR,
                'description' => 'Editor',
            ],
            [
                'name' => Role::TENANT_EXPEDITION,
                'description' => 'Expedição',
            ],
            [
                'name' => Role::TENANT_PARTNER,
                'description' => 'Parceiro',
            ],

        ];

    }

}
