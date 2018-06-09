<?php

use Illuminate\Database\Seeder;

class DatabaseTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call(PrivilegeSeeder::class);
        $this->call(RoleAdminSeeder::class);
        $this->call(RoleTenantSeeder::class);
        $this->call(RoleRegularSeeder::class);

        $this->call(TenantTestSeeder::class);
        $this->call(UserAdminTestSeeder::class);
        $this->call(UserTenantTestSeeder::class);
        $this->call(UserRegularTestSeeder::class);
    }
}
