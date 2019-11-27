<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Model extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model', function (Blueprint $table) {
            $table->string('Model',50)->primary();
            $table->enum('Klasa',array('mala','srednja','velika','luksuzna'));
            $table->enum('Tip_menjaca',array('manuelni','automatski'));
            $table->tinyInteger('Broj_sedista');
            $table->tinyInteger('Broj_vrata');
            $table->tinyInteger('Broj_torbi');
            $table->string('slika',100);
            $table->mediumText('opis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model');
    }
}
