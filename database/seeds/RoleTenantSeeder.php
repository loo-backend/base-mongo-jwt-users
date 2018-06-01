<?php

use App\Privilege;
use App\User;
use Illuminate\Database\Seeder;
use App\Role;
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
            'name' => $data['name'],
            'description' => $data['description'],
            'is_tenant' => User::TENANT_USER,
            'role_uuid' => Uuid::generate(4)->string,
            'default' => true
        ]);


        if( $data['name'] === Role::TENANT_ADMIN ) {

            $all = Privilege::where('name', Privilege::ALL)->first();

            $role->privileges()->create([
                'name' => $all->name,
                'description' => $all->description,
                'privilege_uuid' => $all->privilege_uuid,
            ]);

        } else {

            $browser = Privilege::where('name', Privilege::BROWSER)->first();
            $read    = Privilege::where('name', Privilege::READ)->first();
            $add     = Privilege::where('name', Privilege::ADD)->first();
            $edit    = Privilege::where('name', Privilege::EDIT)->first();
            $delete  = Privilege::where('name', Privilege::DELETE)->first();

            $role->privileges()->create([
                'name' => $browser->name,
                'description' => $browser->description,
                'privilege_uuid' => $browser->privilege_uuid,
            ]);

            $role->privileges()->create([
                'name' => $read->name,
                'description' => $read->description,
                'privilege_uuid' => $read->privilege_uuid,
            ]);

            if ($data['name'] !== Role::ADMIN_STAFF_INITIAL) {

                $role->privileges()->create([
                    'name' => $add->name,
                    'description' => $add->description,
                    'privilege_uuid' => $add->privilege_uuid,
                ]);

                $role->privileges()->create([
                    'name' => $edit->name,
                    'description' => $edit->description,
                    'privilege_uuid' => $edit->privilege_uuid,
                ]);

            }

            if ($data['name'] !== Role::TENANT_EXPEDITION) {

                $role->privileges()->create([
                    'name' => $delete->name,
                    'description' => $delete->description,
                    'privilege_uuid' => $delete->privilege_uuid,
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
