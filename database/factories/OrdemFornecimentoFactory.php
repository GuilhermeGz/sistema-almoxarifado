<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\OrdemFornecimento::class, function (Faker $faker) {
    return [
        'num_contrato' => '554433',
        'pregao' => 'Pregao',
        'codigo' => '5533332222'
    ];
});
