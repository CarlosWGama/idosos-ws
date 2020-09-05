<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEduFisAcompanhamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edu_fis_acompanhamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            //Gerais
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->date('data');
            $table->boolean('aprovado')->default(false);

            //Evolução
            //Desempenho Funcional
            $table->integer('sentar_cadeira')->nullable();
            $table->integer('flexao_cotovelo')->nullable();
            $table->integer('sentar_pes')->nullable();
            $table->integer('timed_up_go')->nullable();
            $table->integer('costas_maos')->nullable();
            $table->integer('caminhada')->nullable();
            
            //Antropometria
            $table->decimal('massa_corporal', 11, 3)->nullable();
            $table->decimal('imc', 11, 2)->nullable();
            $table->integer('estatura')->nullable();

            //Força e Pressão Manual
            $table->decimal('preensao_manual1', 11, 3)->nullable();
            $table->decimal('preensao_manual2', 11, 3)->nullable();
            $table->decimal('preensao_manual3', 11, 3)->nullable();

            //Hemodinâmica
            $table->integer('pas')->nullable();
            $table->integer('pad')->nullable();
            $table->integer('fc')->nullable();
            $table->text('conduta')->nullable();

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
        Schema::dropIfExists('edu_fis_acompanhamentos');
    }
}
