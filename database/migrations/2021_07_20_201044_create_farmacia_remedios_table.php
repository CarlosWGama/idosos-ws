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
            $table->integer('forma_farmaceutica')->comment('1 - Liquido |2 -  Comprimido | 3 - Capsula | 4 -  Pomada | 5 -  Injetável');
            $table->string('dosagem')->nullable();
            $table->date('validade')->nullable();
            $table->integer('quantidade')->nullable();
            $table->integer('saida')->nullable();
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
