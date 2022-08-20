<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Setor;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Setor::class, function (Faker $faker) {

    return [
        'nome' => 'Setor',
    ];
});
