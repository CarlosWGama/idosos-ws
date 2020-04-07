<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDadosClinicosCondicoesClinicas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dados_clinicos_condicoes_clinicas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dados_clinicos_id');
            $table->foreign('dados_clinicos_id')->references('id')->on('dados_clinicos');
            $table->unsignedBigInteger('condicao_clinica_id');
            $table->foreign('condicao_clinica_id')->references('id')->on('condicoes_clinicas');
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
        Schema::dropIfExists('dados_clinicos_condicoes_clinicas');
    }
}
