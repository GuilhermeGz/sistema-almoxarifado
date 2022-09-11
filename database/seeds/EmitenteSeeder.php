<?php

use Illuminate\Database\Seeder;

class EmitenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Emitente::class, 1)->create();
    }
}
