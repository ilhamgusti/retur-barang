<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ReturItem;
use Faker\Generator as Faker;

$factory->define(ReturItem::class, function (Faker $faker) {
    return [
        'is_valid' => $faker->boolean,
    ];
});
