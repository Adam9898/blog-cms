<?php


namespace App\Repositories;


use App\User;

class UserRepository {

    public function createNewUser(User $user) {
        return $user->save();
    }

}
