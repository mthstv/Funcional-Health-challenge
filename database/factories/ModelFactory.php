<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Conta;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Conta::class, function () {
    return [
        'conta' => rand(10000, 99999)
    ];
});
