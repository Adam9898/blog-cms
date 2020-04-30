<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Blog;
use App\Comment;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Blog::class, function (Faker $faker) {
    return [
        'title' => Str::random(20),
        'content' => Str::random(120),
        'user_id' => factory(User::class)
    ];
});
