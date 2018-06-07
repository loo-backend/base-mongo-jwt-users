<?php

use App\Entities\Privilege;
use App\Entities\Role;
use Illuminate\Database\Seeder;
use App\Entities\User;

class UserRegularSeeder extends Seeder
{


    public function run()
    {
        $this->userRegular();
    }

    private function userRegular()
    {

        $users = factory(User::class,5)->create();
        $users->each(function ($user) {

            $roleFirst = Role::where('name', Role::REGULAR_USER)->first();

            $role = $user->roles()->create([
                'name' => $roleFirst->name,
                'roleUuid' => $roleFirst->uuid,
            ]);

            $rolesAll = Role::where('name', Role::REGULAR_USER)->get();

            foreach ($rolesAll as $item) {

                foreach ($item->privileges as $privilege) {

                    $user->privileges()->create([
                        'roleId' => $role->id,
                        'roleUuid' => $roleFirst->uuid,
                        'name' => $privilege->name
                    ]);

                }

            }

        });

    }

}
