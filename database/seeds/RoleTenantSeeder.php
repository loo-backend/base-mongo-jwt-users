<?php

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
                'name' => Role::TENANT_ADMINISTRATOR,
                'description' => 'Administrador',
                'administrator' => User::REGULAR_USER
            ],
            [
                'name' => Role::TENANT_EDITOR,
                'description' => 'Editor',
                'administrator' => User::REGULAR_USER
            ],
            [
                'name' => Role::TENANT_DEVELOP,
                'description' => 'Desenvolvedor',
                'administrator' => User::REGULAR_USER
            ],
            [
                'name' => Role::TENANT_PARTNER,
                'description' => 'Parceiro',
                'administrator' => User::REGULAR_USER
            ],

        ];

    }

}
