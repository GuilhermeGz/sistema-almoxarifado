<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemSolicitacaos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_solicitacaos', function (Blueprint $table) {
            $table->id();
            $table->integer('quantidade_solicitada');
            $table->integer('quantidade_aprovada')->nullable();
            $table->unsignedInteger('material_id')->index();
            $table->foreign('material_id')->references('id')->on('materials');
            $table->unsignedInteger('solicitacao_id')->index();
            $table->foreign('solicitacao_id')->references('id')->on('solicitacaos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_solicitacaos');
    }
}
