<?php

use Illuminate\Database\Seeder;

class NotificacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuarios = \App\Usuario::all();
        for ($i = 1; $i <= count($usuarios); $i++) {
            if ($usuarios->find($i)->cargo_id == 1) {
                factory(\App\Notificacao::class, 1)->create(['usuario_id' => $i]);
            }
        }
    }
}
