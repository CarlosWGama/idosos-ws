<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFisioProntuariosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fisio_prontuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            
            //Para saber os valores tomar como base nutricao-ficha.page.html
            //Formulário
            $table->date('data');
            $table->string('diagnostico_clinico')->nullable();
            $table->string('queixas_principais')->nullable();
     
            //Mini Mental Test
            $table->integer('clock_task')->nullable();
            $table->integer('barthel')->nullable();
            $table->integer('ppt')->nullable();
            
            //Sinais vitais
            $table->integer('fc')->nullable();
            $table->integer('fr')->nullable();
            $table->integer('t')->nullable();
            $table->string('pa')->nullable();
            
            //Nível de Consciência
            $table->integer('nivel_consciencia')->nullable()->comment('1 - Lúcido | 2 - Semi lucido | 3 - Desorientado | 4 - Insconsciente');
            
            //Estado Mental
            $table->integer('estado_mental')->nullable()->comment('1 - Calmo | 2 - Agitado | 3 - Depressivo | 4 - Ansioso | 5 - Agressivo');
            
            //Sistema Respiratório
            $table->integer('sistema_respiratorio')->nullable()->comment('1 - Espontâneo | 2 - Com suporte');
            $table->text('ventilado_suporte_o2')->nullable();
            $table->integer('ritmo')->nullable()->comment('1 - regular | 2 - taquipnéia  | 3 - bradipnéia  | 4 - dispnéia');
            $table->integer('padrao_muscular_ventilatório')->nullable()->comment('1 - diafragmatico  | 2 - costo-diafragmático  | 3 - intercostal   | 4 - acessório | 5 - paradoxal ');
            $table->integer('expansibilidade_toracica')->nullable()->comment('1 - normal  | 2 - diminuída  | 3 - assimetríca ');
            $table->string('expansibilidade_toracica_assimetrica')->nullable();
            $table->integer('ausculta')->nullable()->comment('1 - mvbd sra  | 2 - mv diminuído | 3 - mv abolido');
            $table->string('ausculta_mv_diminuido')->nullable();
            $table->string('ausculta_mv_abolido')->nullable();
            $table->integer('ruidos_adventicios')->nullable()->comment('1 - crepitações   | 2 - roncos  | 3 - sibilos');
            $table->integer('tosse')->nullable()->comment('1 - ausente | 2 - seca | 3 - úmida | 4 - produtiva ');
            $table->string('aspecto_secrecao')->nullable();
            
            //SISTEMA OSTEOMIOARTICULAR
            $table->integer('sistema_osteomioarticular')->nullable()->comment('1 - mov. Voluntário  | 2 - mov. Involuntário  | 3 - plegia  | 4 - paresia  ');
            $table->integer('forca_muscular')->nullable()->comment('1 - normal  | 2 - diminuída ');
            $table->integer('tonus')->nullable()->comment('1 - normal  | 2 - hipotônico | 3 - hipertônico | 4 - clônus ');
            $table->boolean('amplitude_articular_normal')->default(false);
            $table->boolean('amplitude_articular_diminuida')->default(false);
            $table->string('amplitude_articular_diminuida_obs')->nullable();
            $table->boolean('amplitude_articular_luxacao')->default(false);
            $table->string('amplitude_articular_luxacao_obs')->nullable();
            $table->boolean('amplitude_articular_rigidez')->default(false);
            $table->string('amplitude_articular_rigidez_obs')->nullable();
            $table->boolean('amplitude_articular_fratura')->default(false);
            $table->string('amplitude_articular_fratura_obs')->nullable();
            $table->boolean('amplitude_articular_desvio')->default(false);
            $table->string('amplitude_articular_desvio_obs')->nullable();
            
            //Deambutação
            $table->integer('deambutacao')->nullable()->comment('1 - Livre  | 2 - bengala  | 3 - andador  | 4 - cadeira de rodas | 5 -  leito  ');
            $table->string('marcha')->nullable();
            $table->integer('equilibrio')->nullable()->comment('1 - normal  | 2 - anormal ');
            $table->string('equilibrio_anormal')->nullable();
            $table->string('pele')->nullable();
            $table->string('edema_local')->nullable();
            $table->string('edema_tipo')->nullable();
            $table->integer('edema_grau')->nullable();
            $table->string('sequelas')->nullable();
            $table->integer('aparelho_genitourinario')->nullable()->comment('1 - contigência  | 2 - incontigência | 3 - Função sexual ');
            $table->string('aparelho_genitourinario_incontigencia')->nullable();
            $table->string('aparelho_genitourinario_funcao_sexual')->nullable();

            //Final
            $table->text('diagnostico_fisioterapeutico')->nullable();
            $table->text('objetivos')->nullable();
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
        Schema::dropIfExists('fisio_prontuarios');
    }
}
