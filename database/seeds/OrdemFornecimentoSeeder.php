<?php

use Illuminate\Database\Seeder;

class OrdemFornecimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\OrdemFornecimento::class, 1)->create();
    }
}
