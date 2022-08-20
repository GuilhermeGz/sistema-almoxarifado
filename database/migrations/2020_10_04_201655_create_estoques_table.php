<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstoquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estoques', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('quantidade');
            $table->unsignedInteger('material_id')->index();
            $table->foreign('material_id')->references('id')->on('materials');
            $table->softDeletes();

            $table->unsignedInteger('deposito_id')->index();
            $table->foreign('deposito_id')->references('id')->on('depositos');

            $table->unsignedInteger('setor_id')->index();
            $table->foreign('setor_id')->references('id')->on('setors');

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
        Schema::dropIfExists('estoques');
    }
}
