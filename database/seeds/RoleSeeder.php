<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Roles;
use Webpatser\Uuid\Uuid;

class RolesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @throws Exception
     */
    public function run()
    {

        foreach ($this->dataRoles() as $data) {

            Role::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'role_uuid' => Uuid::generate(4)->string
            ]);

        }

    }

    public function dataRoles()
    {
        return [

            [
                'name' => Roles::ADMINISTRATOR,
                'description' => 'Administrador Geral'
            ],
            [
                'name' => Roles::ADMIN_STAFF_FINANCE,
                'description' => 'Departamento Financeiro'
            ],
            [
                'name' => Roles::ADMIN_STAFF_COMMERCIAL,
                'description' => 'Departamento Comercial'
            ],
            [
                'name' => Roles::ADMIN_STAFF_SUPPORT,
                'description' => 'Departamento de Suporte'
            ],
            [
                'name' => Roles::ADMIN_STAFF_INITIAL,
                'description' => 'Aguardando escolha de Departamento'
            ],
            [
                'name' => Roles::TENANT_ADMINISTRATOR,
                'description' => 'Administrador'
            ],
            [
                'name' => Roles::TENANT_EDITOR,
                'description' => 'Editor'
            ],
            [
                'name' => Roles::TENANT_DEVELOP,
                'description' => 'Desenvolvedor'
            ],
            [
                'name' => Roles::TENANT_PARTNER,
                'description' => 'Parceiro'
            ],

        ];

    }

}
