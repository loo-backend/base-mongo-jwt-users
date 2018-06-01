<?php

use App\Privilege;
use App\User;
use Illuminate\Database\Seeder;
use App\Role;
use Webpatser\Uuid\Uuid;

class RoleAdminSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @throws Exception
     */
    public function run()
    {

        foreach ($this->dataRoles() as $data) {

            $role = Role::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'role_uuid' => Uuid::generate(4)->string,
                'default' => true
            ]);

            if( $data['name'] === Role::ADMIN ) {

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

                if ($data['name'] !== Role::ADMIN_STAFF_INITIAL
                    && $data['name'] !== Role::ADMIN_STAFF_COMMERCIAL) {

                    $role->privileges()->create([
                        'name' => $delete->name,
                        'description' => $delete->description,
                        'privilege_uuid' => $delete->privilege_uuid,
                    ]);

                }

            }

        }

    }

    public function dataRoles()
    {
        return [

            [
                'name' => Role::ADMIN,
                'description' => 'Administrador Geral',
            ],
            [
                'name' => Role::ADMIN_STAFF_AUDIT,
                'description' => 'Departamento de Auditoria',
            ],
            [
                'name' => Role::ADMIN_STAFF_FINANCE,
                'description' => 'Departamento Financeiro',
            ],
            [
                'name' => Role::ADMIN_STAFF_COMMERCIAL,
                'description' => 'Departamento Comercial',
            ],
            [
                'name' => Role::ADMIN_STAFF_SUPPORT,
                'description' => 'Departamento de Suporte',
            ],
            [
                'name' => Role::ADMIN_STAFF_INITIAL,
                'description' => 'Aguardando escolha de Departamento',
            ],

        ];

    }

}
