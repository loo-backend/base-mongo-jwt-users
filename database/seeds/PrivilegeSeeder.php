<?php

use Illuminate\Database\Seeder;
use App\Privilege;
use Webpatser\Uuid\Uuid;

class PrivilegeSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @throws Exception
     */
    public function run()
    {

        foreach ($this->dataPrivileges() as $data) {

            Privilege::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'privilege_uuid' => Uuid::generate(4)->string
            ]);

        }

    }

    public function dataPrivileges()
    {
        return [

            [
                'name' => Privilege::ALL,
                'description' => 'Todos',
                'administrator' => true
            ],
            [
                'name' => Privilege::BROWSER,
                'description' => 'Browser',
                'administrator' => true
            ],
            [
                'name' => Privilege::READ,
                'description' => 'Pode Ler',
            ],
            [
                'name' => Privilege::ADD,
                'description' => 'Pode Adicionar'
            ],
            [
                'name' => Privilege::EDIT,
                'description' => 'Pode Editar'
            ],
            [
                'name' => Privilege::DELETE,
                'description' => 'Pode Deletar'
            ]

        ];

    }

}
