<?php


namespace App\Repositories;


use App\User;
use Illuminate\Support\Facades\DB;

class UserRepository {

    public function createNewUser(User $user) {
        return $user->save();
    }

    public function getUserRoles(User $user) {
        return $user->roles()->getResults();
    }

    public function findUserByEmail(string $email) {
        return User::where('email', $email)->first();
    }

}
