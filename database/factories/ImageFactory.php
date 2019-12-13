<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use App\User;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'user_id' => User::inRandomOrder()->first()->id,
        'description' => $faker->text(180),
        'image' => $faker->image(public_path('storage/images'), random_int(400, 960), random_int(400, 960), null, false)
    ];
});
