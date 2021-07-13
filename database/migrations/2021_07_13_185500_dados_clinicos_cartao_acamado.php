<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DadosClinicosCartaoAcamado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dados_clinicos', function (Blueprint $table) {
            $table->unsignedBigInteger('cartao_sus_numero')->nullable();
            $table->tinyInteger('cf_acamado')->default(0)->comment('0 Não | 1 Acamado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dados_clinicos', function (Blueprint $table) {
            $table->dropColumn('cartao_sus_numero');
            $table->dropColumn('cf_acamado');
        });
    }
}
