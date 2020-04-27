<?php


namespace App\Repositories;


use App\User;

class UserRepository {

    public function createNewUser(User $user) {
        return $user->save();
    }

    public function getUserRoles(User $user) {
        return $user->roles()->getResults();
    }

}
