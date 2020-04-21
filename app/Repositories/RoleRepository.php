<?php


namespace App\Repositories;


use App\Enums\UserRole;
use App\Role;

class RoleRepository {

    public function getRoleIdByName($name): int {
        $role = Role::where('role_name', $name)->get();
        return $role[0]->id;
    }

}
