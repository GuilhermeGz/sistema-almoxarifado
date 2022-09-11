<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Material;
use Faker\Generator as Faker;

$factory->define(Material::class, function (Faker $faker) {
    $faker = \Faker\Factory::create();
    \Bezhanov\Faker\ProviderCollectionHelper::addAllProvidersTo($faker);
    return [
        'nome' => $faker->productName,
        'codigo' => rand(000000, 999999),
        'descricao' => $faker->text,
        'quantidade_minima' => rand(0, 50),
        'imagem' => 'default.png',
        'unidade' => 'unidade'
    ];
});
