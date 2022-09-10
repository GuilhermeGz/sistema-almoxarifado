<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\NotaFiscal;
use Faker\Generator as Faker;

$factory->define(NotaFiscal::class, function (Faker $faker) {
    return [
        'ordem_fornecimento_id' => 1,
        'data_emissao' => today(),
        'serie' => '5533332222',
        'natureza_operacao' => 'Operação de Venda',
        'numero' => '221133',
        'valor_nota' => '500',
        'emitente_id' => 1,
        'status' => 'concluido',
    ];
});
