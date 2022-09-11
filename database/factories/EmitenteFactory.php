<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Emitente::class, function (Faker $faker) {
    return [
        'inscricao_estadual' => '3332211',
        'cnpj' => '2211444444444',
        'razao_social' => 'Bar dos alcoólatras anônimos',
    ];
});
