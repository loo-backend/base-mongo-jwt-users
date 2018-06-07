<?php

use Illuminate\Database\Seeder;
use App\Entities\Privilege;
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
                'uuid' => Uuid::generate(4)->string,
                'name' => $data['name'],
                'description' => $data['description'],
            ]);

        }

    }

    public function dataPrivileges()
    {
        return [

            [
                'name' => Privilege::ALL,
                'description' => 'Todos',
            ],
            [
                'name' => Privilege::BROWSER,
                'description' => 'Browser',
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
