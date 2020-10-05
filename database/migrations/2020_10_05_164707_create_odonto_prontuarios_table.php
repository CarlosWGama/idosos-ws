<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOdontoProntuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odonto_prontuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            
            //Para saber os valores tomar como base nutricao-ficha.page.html
            //Formulário
            $table->date('data');

            //ODONTOGRAMA
            $table->integer('odontograma_18')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_17')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_16')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_15')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_14')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_13')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_12')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_11')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_21')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_22')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_23')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_24')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_25')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_26')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_27')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_28')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_48')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_47')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_46')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_45')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_44')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_43')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_42')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_41')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_31')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_32')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_33')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_34')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_35')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_36')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_37')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');
            $table->integer('odontograma_38')->nullable()->comment('1 - Cariado | 2 - Mancha Branca ativa | 3 - Mancha Branca Inativa | 4 - Restaurado | 5 - Extraído | 6 - Hígido | 7 - Ausente | 8 - Extração Indicada | 9 - Tratamento Pendente');

            $table->string('condicoes_dentais_18')->nullable();
            $table->string('condicoes_dentais_17')->nullable();
            $table->string('condicoes_dentais_16')->nullable();
            $table->string('condicoes_dentais_15')->nullable();
            $table->string('condicoes_dentais_14')->nullable();
            $table->string('condicoes_dentais_13')->nullable();
            $table->string('condicoes_dentais_12')->nullable();
            $table->string('condicoes_dentais_11')->nullable();
            $table->string('condicoes_dentais_21')->nullable();
            $table->string('condicoes_dentais_22')->nullable();
            $table->string('condicoes_dentais_23')->nullable();
            $table->string('condicoes_dentais_24')->nullable();
            $table->string('condicoes_dentais_25')->nullable();
            $table->string('condicoes_dentais_26')->nullable();
            $table->string('condicoes_dentais_27')->nullable();
            $table->string('condicoes_dentais_28')->nullable();
            $table->string('condicoes_dentais_48')->nullable();
            $table->string('condicoes_dentais_47')->nullable();
            $table->string('condicoes_dentais_46')->nullable();
            $table->string('condicoes_dentais_45')->nullable();
            $table->string('condicoes_dentais_44')->nullable();
            $table->string('condicoes_dentais_43')->nullable();
            $table->string('condicoes_dentais_42')->nullable();
            $table->string('condicoes_dentais_41')->nullable();
            $table->string('condicoes_dentais_31')->nullable();
            $table->string('condicoes_dentais_32')->nullable();
            $table->string('condicoes_dentais_33')->nullable();
            $table->string('condicoes_dentais_34')->nullable();
            $table->string('condicoes_dentais_35')->nullable();
            $table->string('condicoes_dentais_36')->nullable();
            $table->string('condicoes_dentais_37')->nullable();
            $table->string('condicoes_dentais_38')->nullable();


            //Avaliação da condição periodontal
            $table->integer('avaliacao_periodontal_18')->nullable();
            $table->integer('avaliacao_periodontal_17')->nullable();
            $table->integer('avaliacao_periodontal_16')->nullable();
            $table->integer('avaliacao_periodontal_15')->nullable();
            $table->integer('avaliacao_periodontal_14')->nullable();
            $table->integer('avaliacao_periodontal_13')->nullable();
            $table->integer('avaliacao_periodontal_12')->nullable();
            $table->integer('avaliacao_periodontal_11')->nullable();
            $table->integer('avaliacao_periodontal_21')->nullable();
            $table->integer('avaliacao_periodontal_22')->nullable();
            $table->integer('avaliacao_periodontal_23')->nullable();
            $table->integer('avaliacao_periodontal_24')->nullable();
            $table->integer('avaliacao_periodontal_25')->nullable();
            $table->integer('avaliacao_periodontal_26')->nullable();
            $table->integer('avaliacao_periodontal_27')->nullable();
            $table->integer('avaliacao_periodontal_28')->nullable();
            $table->integer('avaliacao_periodontal_48')->nullable();
            $table->integer('avaliacao_periodontal_47')->nullable();
            $table->integer('avaliacao_periodontal_46')->nullable();
            $table->integer('avaliacao_periodontal_45')->nullable();
            $table->integer('avaliacao_periodontal_44')->nullable();
            $table->integer('avaliacao_periodontal_43')->nullable();
            $table->integer('avaliacao_periodontal_42')->nullable();
            $table->integer('avaliacao_periodontal_41')->nullable();
            $table->integer('avaliacao_periodontal_31')->nullable();
            $table->integer('avaliacao_periodontal_32')->nullable();
            $table->integer('avaliacao_periodontal_33')->nullable();
            $table->integer('avaliacao_periodontal_34')->nullable();
            $table->integer('avaliacao_periodontal_35')->nullable();
            $table->integer('avaliacao_periodontal_36')->nullable();
            $table->integer('avaliacao_periodontal_37')->nullable();
            $table->integer('avaliacao_periodontal_38')->nullable();

            $table->text('condicao_higiene_obs_periodontal')->nullable();
            
            //Tipo de Hipoteses
            $table->integer('protese_superior')->nullable()->comment('0 - Não usa proteses | 1 - Usa protese fixa | 2 - Usa mais do que uma ponte fixa | 3 - Usa protese parcial removível | 4 - Usa uma ou mais  ponte fixas  e uma ou mais ppr | 5 - Usa protese dentarial total');
            $table->integer('protese_inferior')->nullable()->comment('0 - Não usa proteses | 1 - Usa protese fixa | 2 - Usa mais do que uma ponte fixa | 3 - Usa protese parcial removível | 4 - Usa uma ou mais  ponte fixas  e uma ou mais ppr | 5 - Usa protese dentarial total');


            //Final
            $table->text('busca_ativa_lesoes')->nullable();
            $table->text('descricao_lesao')->nullable();
            $table->text('observacoes')->nullable();
        
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
        Schema::dropIfExists('odonto_prontuarios');
    }
}
