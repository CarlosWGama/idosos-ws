<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDadosClinicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dados_clinicos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->string('condicao_clinica_outras')->nullable();
            $table->boolean('plano')->default(false);
            $table->boolean('cartao_sus')->default(false);
            $table->boolean('fumante')->default(false);
            $table->tinyInteger('fumante_idade')->nullable();
            $table->tinyInteger('fumante_media_cigarros')->default(0);
            $table->tinyInteger('etilista')->default(0)->comment('1 - ex etilista | 0 - nunca foi etilista');
            $table->tinyInteger('sono')->default(0)->comment('0 - dorme bem | 1 - tem insônia | 2 - Não sabe informar');
            $table->boolean('protese_dentaria')->default(false);
            $table->boolean('medicamento_continuo')->default(false);
            $table->tinyInteger('medicamento_fornecimento')->default(0)->comment('0 Não | 1 Sim | 2 alguns são fornecidos outros comprados');
            $table->tinyInteger('queda')->default(0)->comment('0 não | 1 sim | 3 não recorda');
            $table->tinyInteger('dispositivo_andar')->default(0)->comment('0 Nenhum | 1 andador | 2 utilizava cadeira de rodas | 3 bengala ');
            $table->boolean('atividade_recreativa')->default(false);
            $table->tinyInteger('cf_banhar')->default(0)->comment('0 independente | 1 necessita de ajuda não humana |2 Dependência completa');
            $table->tinyInteger('cf_vestir')->default(0)->comment('0 independente | 1 necessita de ajuda não humana |2 Dependência completa');
            $table->tinyInteger('cf_uso_banheiro')->default(0)->comment('0 independente | 1 necessita de ajuda não humana |2 Dependência completa');
            $table->tinyInteger('cf_transferir')->default(0)->comment('0 independente | 1 necessita de ajuda não humana |2 Dependência completa');
            $table->tinyInteger('cf_continencia')->default(0)->comment('0 Tem completo controle sobre suas eliminações |1 É parcial ou totalmente incontinente do intestino e bexiga ');
            $table->tinyInteger('cf_alimentar')->default(0)->comment('0 independente | 1 necessita de ajuda não humana |2 Dependência completa');
            $table->softDeletes();
            $table->timestamps();
            // condicoes_clinicas?: number[],
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dados_clinicos');
    }
}
