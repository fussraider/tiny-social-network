<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use App\User;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'user_id' => User::inRandomOrder()->first()->id,
        'title' => $faker->text(64),
        'body' => strip_tags($faker->randomHtml(4, 15), '<p><div><table><tr><td><a><ul><li><ol>'),
    ];
});
