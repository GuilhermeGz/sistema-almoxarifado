<?php

use Illuminate\Database\Seeder;

class DepositoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Deposito::class, 1)->create(['nome' => 'Atendimento']);
    }
}
