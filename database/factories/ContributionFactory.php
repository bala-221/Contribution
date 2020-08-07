<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Contribution;
use Faker\Generator as Faker;

$factory->define(Contribution::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\User::class),
        'title' => $faker->paragraph,
        'monthlyContribution' => $faker->numberBetween($min = 1000, $max = 10000),
        'startDate' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+ 5 years'),
    ];
});

