<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MaterialNotas;
use Faker\Generator as Faker;

$factory->define(MaterialNotas::class, function (Faker $faker) {
    return [
        'material_id' => 1,
        'nota_fiscal_id' => 1,
        'valor' => 5,
        'quantidade' => 10,
    ];
});
