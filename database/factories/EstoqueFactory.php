<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Estoque;
use Faker\Generator as Faker;

$factory->define(Estoque::class, function (Faker $faker) {
    return [
        'material_id' => 1,
        'deposito_id' => 1,
        'quantidade' => rand(50, 100),
        'setor_id' => 1,
    ];
});
