<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProntuarioNutricaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prontuarios_nutricao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->boolean('aprovado');
            
            //Para saber os valores tomar como base nutricao-ficha.page.html
            //Formulário
            $table->date('data');
            $table->string('habito_intestinal_dia')->nullable();
            $table->string('habito_intestinal_semana')->nullable();
            $table->integer('consistencia_fezes');
            $table->boolean('laxante');
            $table->integer('apetite');
            $table->integer('sobra_comida');
            $table->string('aversao_alimentar')->nullable();
            $table->string('intolerencia_alimentar')->nullable();
            $table->string('alergia_alimentar')->nullable();
            $table->boolean('sede');
            $table->integer('liquidos_diarios');
            $table->integer('liquido_consumo');
            $table->boolean('suplemento');
            
            $table->float('peso_atual');
            $table->float('peso_usual');
            $table->float('peso_estimado');
            $table->float('perda_peso');
            $table->float('segmentacao_amputado');
            $table->float('altura');
            $table->float('altura_joelho');
            $table->float('semi_envergadura');
            $table->float('altura_estimada');
            $table->float('imc');
            $table->float('circunferencia_panturrilha');
            $table->float('circunferencia_braco');
            $table->float('circunferencia_pulso');
            $table->float('dct');
            $table->float('dcse');
            $table->float('circunferencia_muscular_braco');
            $table->float('circunferencia_cintura');
            $table->float('circunferencia_cintura_tipo');
            $table->boolean('marcapasso');
            $table->boolean('edema');
            $table->string('edema_localizacao')->nullable();
            $table->boolean('cacifo');
            $table->integer('lado_dominante');
            
            //Avaliação Força Palmar
            $table->float('fp_mao_direita1');
            $table->float('fp_mao_direita2');
            $table->float('fp_mao_direita3');
            $table->float('fp_mao_esquerda1');
            $table->float('fp_mao_esquerda2');
            $table->float('fp_mao_esquerda3');
            
            //Exame Físico
            $table->boolean('c_consumo_musculo_temporal');
            $table->boolean('c_consumo_bola_gordurosa');
            $table->boolean('c_arco_zigomatico_aparente');
            $table->boolean('c_depressao_masseter');
            $table->boolean('t_clavicula_aparente');
            $table->boolean('t_esterno_aparente');
            $table->boolean('t_ombros_quadrados');
            $table->boolean('p_proeminência_supra_infra');
            $table->boolean('o_esclerotica');
            $table->boolean('o_mucosa_hipocoradas');
            $table->boolean('o_orbitas_profundas');
            $table->integer('cf_coloracao_mucosa');
            $table->boolean('ms_edema');
            $table->boolean('mi_edema');
            $table->boolean('mi_joelho_quadrado');
            $table->boolean('pele_manchas');
            $table->boolean('pele_ressecamento');
            $table->boolean('pele_lesoes');
            $table->boolean('pele_turgor');
            $table->boolean('pele_prurido');
            
            //Final
            $table->text('diagnostico');
            $table->text('objetivos');
            $table->text('conduta');
        
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
        Schema::dropIfExists('prontuarios_nutricao');
    }
}
