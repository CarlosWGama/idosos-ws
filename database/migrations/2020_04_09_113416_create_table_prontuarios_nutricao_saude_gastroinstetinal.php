<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProntuariosNutricaoSaudeGastroinstetinal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prontuarios_nutricao_saude_gastrointestinal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('prontuario_id');
            $table->foreign('prontuario_id', 'pnsg_prontuario_id_fk')->references('id')->on('prontuarios_nutricao');
            $table->unsignedBigInteger('saude_gastroinstestinal_id');
            $table->foreign('saude_gastroinstestinal_id', 'pnsg_saude_gastroinstestinal_id_fk')->references('id')->on('nut_saude_gastroinsteinal');
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
        Schema::dropIfExists('prontuarios_nutricao_saude_gastrointestinal');
    }
}
