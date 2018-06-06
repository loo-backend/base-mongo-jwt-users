<?php

use App\Privilege;
use App\Role;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class RoleRegularSeeder extends Seeder
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
    private function createRoles($data)
    {

        $role = Role::create([
            'uuid' => Uuid::generate(4)->string,
            'name' => $data['name'],
            'description' => $data['description'],
            'default' => true
        ]);

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

        $role->privileges()->create([
            'uuid' => $delete->uuid,
            'name' => $delete->name,
            'description' => $delete->description,
        ]);

    }

    public function dataRoles()
    {
        return [
            [
                'name' => Role::REGULAR_USER,
                'description' => 'Usuário Regular',
            ]

        ];

    }

}
