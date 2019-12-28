<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Message;
use App\User;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'category_id' => factory(Category::class),
        'icon' => $faker->randomElement(['fas fa-coins', 'fas fa-book-reader']),
        'title' => $faker->sentence(),
        'content' => $faker->sentences(),
        'link' => null,
    ];
});
