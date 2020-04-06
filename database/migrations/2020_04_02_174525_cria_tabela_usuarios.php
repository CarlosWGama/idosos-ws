<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('senha');
            $table->boolean('admin')->default(false);
            $table->boolean('exibir')->default(false); //Se deve ser exibido no aplicativo
            $table->unsignedBigInteger('profissao_id')->nullable();
            $table->foreign('profissao_id')->references('id')->on('profissoes');
            $table->integer('nivel_acesso')->default(1); //1Professor (Pode tudo no paciente e cadastrar equipe)|2Moderador(Acesso total ao paciente)|3Aluno(Acesso limitado ao paciente) 
            $table->boolean('deletado')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('usuarios');
    }
}
