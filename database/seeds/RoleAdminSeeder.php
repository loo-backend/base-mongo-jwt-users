<?php

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

            Role::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'administrator' => $data['administrator'],
                'role_uuid' => Uuid::generate(4)->string,
                'default' => true
            ]);

        }

    }

    public function dataRoles()
    {
        return [

            [
                'name' => Role::ADMINISTRATOR,
                'description' => 'Administrador Geral',
                'administrator' => User::ADMIN_USER
            ],
            [
                'name' => Role::ADMIN_STAFF_FINANCE,
                'description' => 'Departamento Financeiro',
                'administrator' => User::ADMIN_USER
            ],
            [
                'name' => Role::ADMIN_STAFF_COMMERCIAL,
                'description' => 'Departamento Comercial',
                'administrator' => User::ADMIN_USER
            ],
            [
                'name' => Role::ADMIN_STAFF_SUPPORT,
                'description' => 'Departamento de Suporte',
                'administrator' => User::ADMIN_USER
            ],
            [
                'name' => Role::ADMIN_STAFF_INITIAL,
                'description' => 'Aguardando escolha de Departamento',
                'administrator' => User::ADMIN_USER
            ],

        ];

    }

}
