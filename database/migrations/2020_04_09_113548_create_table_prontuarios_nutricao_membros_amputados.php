<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProntuariosNutricaoMembrosAmputados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prontuarios_nutricao_membros_amputados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('prontuario_id');
            $table->foreign('prontuario_id', 'pnma_prontuario_id_fk')->references('id')->on('prontuarios_nutricao');
            $table->unsignedBigInteger('membro_id');
            $table->foreign('membro_id','pnma_membro_id_fk')->references('id')->on('nut_membros_amputados');
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
        Schema::dropIfExists('prontuarios_nutricao_membros_amputados');
    }
}
