<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Automobili extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('automobili', function (Blueprint $table) {
            $table->string('Broj_sasije',17)->primary();
            $table->string('Broj_saobracajne_dozvole',14)->unique();
            $table->string('Broj_registarskih_tablica',10)->unique();
            $table->string('Model',50);
            $table->integer('Godina_proizvodnje');
            $table->integer('Predjena_km');
            $table->date('Datum_vazenja_registracije');
            $table->integer('Radjen_mali_servis_km');
            $table->integer('Radjen_veliki_servis_km');
            $table->boolean('Aktivan');
            $table->boolean('Servis');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('automobili');
    }
}
