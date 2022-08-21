<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaFiscalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_fiscals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('numero')->unique();
            $table->string('serie');
            $table->date('data_emissao');
            $table->string('natureza_operacao');
            $table->float('valor_nota');
            $table->string('status');

            $table->unsignedInteger('emitente_id')->index();
            $table->foreign('emitente_id')->references('id')->on('emitentes');

            $table->unsignedInteger('ordem_fornecimento_id')->index();
            $table->foreign('ordem_fornecimento_id')->references('id')->on('ordem_fornecimentos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota_fiscals');
    }
}
