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
            
            //Para saber os valores tomar como base nutricao-ficha.page.html
            //Formulário
            $table->date('data');
            $table->string('habito_intestinal_dia')->nullable();
            $table->string('habito_intestinal_semana')->nullable();
            $table->integer('consistencia_fezes')->nullable();
            $table->boolean('laxante')->nullable();
            $table->integer('apetite')->nullable();
            $table->integer('sobra_comida')->nullable();
            $table->string('aversao_alimentar')->nullable();
            $table->string('intolerencia_alimentar')->nullable();
            $table->string('alergia_alimentar')->nullable();
            $table->boolean('sede')->nullable();
            $table->integer('liquidos_diarios')->nullable();
            $table->integer('liquido_consumo')->nullable();
            $table->boolean('suplemento')->nullable();
            
            $table->float('peso_atual')->nullable();
            $table->float('peso_usual')->nullable();
            $table->float('peso_estimado')->nullable();
            $table->float('perda_peso')->nullable();
            $table->float('segmentacao_amputado')->nullable();
            $table->float('altura')->nullable();
            $table->float('altura_joelho')->nullable();
            $table->float('semi_envergadura')->nullable();
            $table->float('altura_estimada')->nullable();
            $table->float('imc')->nullable();
            $table->float('circunferencia_panturrilha')->nullable();
            $table->float('circunferencia_braco')->nullable();
            $table->float('circunferencia_pulso')->nullable();
            $table->float('dct')->nullable();
            $table->float('dcse')->nullable();
            $table->float('circunferencia_muscular_braco')->nullable();
            $table->float('circunferencia_cintura')->nullable();
            $table->float('circunferencia_cintura_tipo')->nullable();
            $table->boolean('marcapasso')->nullable();
            $table->boolean('edema')->nullable();
            $table->string('edema_localizacao')->nullable();
            $table->boolean('cacifo')->nullable();
            $table->integer('lado_dominante')->nullable();
            
            //Avaliação Força Palmar
            $table->float('fp_mao_direita1')->nullable();
            $table->float('fp_mao_direita2')->nullable();
            $table->float('fp_mao_direita3')->nullable();
            $table->float('fp_mao_esquerda1')->nullable();
            $table->float('fp_mao_esquerda2')->nullable();
            $table->float('fp_mao_esquerda3')->nullable();
            
            //Exame Físico
            $table->boolean('c_consumo_musculo_temporal')->nullable();
            $table->boolean('c_consumo_bola_gordurosa')->nullable();
            $table->boolean('c_arco_zigomatico_aparente')->nullable();
            $table->boolean('c_depressao_masseter')->nullable();
            $table->boolean('t_clavicula_aparente')->nullable();
            $table->boolean('t_esterno_aparente')->nullable();
            $table->boolean('t_ombros_quadrados')->nullable();
            $table->boolean('p_proeminência_supra_infra')->nullable();
            $table->boolean('o_esclerotica')->nullable();
            $table->boolean('o_mucosa_hipocoradas')->nullable();
            $table->boolean('o_orbitas_profundas')->nullable();
            $table->integer('cf_coloracao_mucosa')->nullable();
            $table->boolean('ms_edema')->nullable();
            $table->boolean('mi_edema')->nullable();
            $table->boolean('mi_joelho_quadrado')->nullable();
            $table->boolean('pele_manchas')->nullable();
            $table->boolean('pele_ressecamento')->nullable();
            $table->boolean('pele_lesoes')->nullable();
            $table->boolean('pele_turgor')->nullable();
            $table->boolean('pele_prurido')->nullable();
            
            //Final
            $table->text('diagnostico')->nullable();
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
        Schema::dropIfExists('prontuarios_nutricao');
    }
}
