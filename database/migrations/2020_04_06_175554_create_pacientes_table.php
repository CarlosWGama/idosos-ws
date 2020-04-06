<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->date('data_nascimento');
            $table->boolean('masculino')->comment('True - Masculino | 1 - Feminino');
            $table->tinyInteger('escolaridade')->comment('0 -> Analfabeto | 1 - Estudou menos que 4 anos | 2 - Estudou mais de 4 anos'); 
            $table->boolean('tem_filhos');
            $table->tinyInteger('estado_civil')->comment('1 - Solteiro | 2 - Casado | 3 - viuvo | 4 - Separado ou Divorciado');
            $table->tinyInteger('frequencia_familiar')->comment('0 - Nunca ou Raramento | 1 - As vezes | 2 - Sempre');
            $table->date('data_admissao');
            $table->tinyInteger('motivo_admissao')->comment('1 - Ter Tranquilidade | 2 - Tratamento | 3 - Idade | 4 - Morava Sozinho | 5 - Motivo Financeiro | 6 - Não tinha onde morar | 7 - Doença | 8 - Filho, Neta ou Cônjuge trouxe, por achar melhor opção | 9 - Ficou sem familia | 10 - Não soube respodner');
            $table->string('foto')->nullable();
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
        Schema::dropIfExists('pacientes');
    }
}
