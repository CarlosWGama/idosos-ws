<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEduFisProntuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edu_fis_prontuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            
            //Formulário
            $table->date('data');
            $table->decimal('glicemia_capilar', 11, 2)->nullable();
            $table->string('pressao_arterial')->nullable();
            $table->integer('frequencia_cardiaca')->nullable();
            $table->integer('saturacao')->nullable();
            $table->decimal('temperatura', 11,2)->nullable();
            $table->string('pas_tornozelo_direito')->nullable();
            $table->string('pas_tornozelo_esquerdo')->nullable();
            $table->string('pas_braquial_direito')->nullable();
            $table->string('pas_braquial_esquerdo')->nullable();
            $table->string('indice_tornozelo_braquial_direito')->nullable();
            $table->string('indice_tornozelo_braquial_esquerdo')->nullable();
            
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
        Schema::dropIfExists('edu_fis_prontuarios');
    }
}
