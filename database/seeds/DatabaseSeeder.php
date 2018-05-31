<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserAdminSeeder::class);
        $this->call(UserTenantSeeder::class);
        $this->call(RoleAdminSeeder::class);
        $this->call(RoleTenantSeeder::class);
        $this->call(RolePrivilegeSeeder::class);
        $this->call(TenantSeeder::class);
    }
}
