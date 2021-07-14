<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamesClinicos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exames_laboratoriais', function (Blueprint $table) {
            $table->bigIncrements('id');
            //Gerais
            $table->unsignedBigInteger('criado_por');
            $table->foreign('criado_por')->references('id')->on('usuarios');
            $table->unsignedBigInteger('modificado_por')->nullable();
            $table->foreign('modificado_por')->references('id')->on('usuarios');
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->date('data');

            $table->integer('glicemia_jejum')->nullable();
            $table->integer('hgt')->nullable();
            $table->decimal('hemoglobina_glicosilada', 5, 2)->nullable();
            $table->integer('colesterol_total')->nullable();
            $table->integer('hdl')->nullable();
            $table->integer('ldl')->nullable();
            $table->integer('triglicerideos')->nullable();
            $table->decimal('creatinina_serica', 5, 2)->nullable();
            $table->decimal('potassio_serico', 5, 2)->nullable();
            
            $table->integer('equ_infecccao_urinaria')->nullable();
            $table->integer('equ_proteinuria')->nullable();
            $table->decimal('equ_corpos_cetonicos', 5, 2)->nullable();
            $table->integer('equ_sedimento')->nullable();

            $table->integer('microalbuminuria')->nullable();
            $table->integer('proteinuria')->nullable();
            $table->decimal('tsh', 5, 2)->nullable();
            $table->decimal('ecg', 5, 2)->nullable();
            
            $table->decimal('hematocrito', 5, 2)->nullable();
            $table->decimal('hemoglobina', 5, 2)->nullable();
            $table->decimal('vcm', 5, 2)->nullable();
            $table->decimal('chcm', 5, 2)->nullable();
            $table->integer('plaquetas')->nullable();

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
        Schema::dropIfExists('exames_laboratoriais');
    }
}
