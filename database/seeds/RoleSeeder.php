<?php

use App\Enums\UserRole;
use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->role_name = UserRole::Regular;
        $role->save();
        $role = new Role();
        $role->role_name = UserRole::Editor;
        $role->save();
    }
}
