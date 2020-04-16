<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Blog;
use App\Comment;
use App\User;
use Faker\Generator as Faker;

$factory->define(Blog::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'content' => $faker->text,
        'user_id' => factory(User::class)
    ];
});
