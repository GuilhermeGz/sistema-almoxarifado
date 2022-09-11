<?php

use Illuminate\Database\Seeder;

class NotaFiscalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\NotaFiscal::class, 1)->create();
    }
}
