<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('nome');
            $table->string('cep');
            $table->string('endereco');
            $table->string('bairro');

            $table->string('nome_coordenador');
            $table->string('numero_coordenador');
            $table->string('nome_enfermeira');
            $table->string('numero_enfermeira');

            $table->unsignedInteger('setor_id')->index();
            $table->foreign('setor_id')->references('id')->on('setors');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unidades');
    }
}
