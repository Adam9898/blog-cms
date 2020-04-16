<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Blog;
use App\Comment;
use App\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'content' => $faker->text,
        'blog_id' => factory(Blog::class),
        'user_id' => factory(User::class)
    ];
});
