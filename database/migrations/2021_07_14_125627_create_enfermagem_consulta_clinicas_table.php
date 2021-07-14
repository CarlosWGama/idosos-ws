<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnfermagemConsultaClinicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enfermagem_consulta_clinica', function (Blueprint $table) {
            $table->bigIncrements('id');
            //Gerais
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->date('data');
            $table->boolean('aprovado')->default(false);


            //
            $table->string('pressao_arterial')->nullable();
            $table->decimal('peso', 11, 3)->nullable();
            $table->decimal('imc', 11, 2)->nullable();
            
            $table->string('framingham')->nullable();
            $table->string('lesoes_orgao_alvo')->nullable();

            $table->boolean('alteracao_pes')->default(false);
            $table->string('alteracao_pes_qual')->nullable();
            
            $table->boolean('alteracao_fisico')->default(false);
            $table->string('alteracao_fisico_qual')->nullable();
          
            $table->boolean('fragilidade')->default(false);
            $table->string('fragilidade_qual')->nullable();
            
            $table->boolean('orientacao_nutricional')->default(false);
            $table->boolean('orientacao_atividade_fisica')->default(false);

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
        Schema::dropIfExists('enfermagem_consulta_clinica');
    }
}
