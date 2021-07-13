<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnfermagemProntuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enfermagem_prontuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            
            //Formulário
            $table->date('data');
            $table->integer('estatura')->nullable();
            $table->integer('perimetro_braquial')->nullable();
            $table->boolean('osteoporose')->default(false);
            $table->boolean('demencia')->default(false);
            $table->string('demencia_qual')->nullable();
            
            //Avaliação Multidimensional (alterações)
            $table->boolean('nutricao')->default(false);
            $table->string('nutricao_qual')->nullable();

            $table->boolean('visao')->default(false);
            $table->string('visao_qual')->nullable();
            
            $table->boolean('audicao')->default(false);
            $table->string('audicao_qual')->nullable();
            
            $table->boolean('incontinencia')->default(false);
            $table->string('incontinencia_qual')->nullable();
            
            $table->boolean('depressao')->default(false);
            $table->string('depressao_qual')->nullable();
            $table->date('depressao_data')->nullable();
            
            $table->boolean('cognicao')->default(false);
            $table->string('cognicao_qual')->nullable();
            
            $table->boolean('mmss')->default(false);
            $table->string('mmss_qual')->nullable();
            $table->date('mmss_data')->nullable();
            
            $table->boolean('mmii')->default(false);
            $table->string('mmii_qual')->nullable();
            $table->date('mmii_data')->nullable();
            
            $table->boolean('queda')->default(false);
            $table->date('queda_data')->nullable();
            
            //===========
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
        Schema::dropIfExists('enfermagem_prontuarios');
    }
}
