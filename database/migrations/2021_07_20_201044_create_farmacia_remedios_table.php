<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmaciaRemediosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farmacia_remedios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('dosagem');
            $table->date('validade');
            $table->integer('quantidade');
            $table->integer('saida');
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
        Schema::dropIfExists('farmacia_remedios');
    }
}
