<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Role;
use App\Enums\UserRole;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'role_name' => UserRole::Regular
    ];
});
