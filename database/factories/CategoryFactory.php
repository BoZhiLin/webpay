<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    static $index = 0;
    $names = ['test_1', 'test_2', 'test_3'];

    return [
        'name' => $names[$index++]
    ];
});
