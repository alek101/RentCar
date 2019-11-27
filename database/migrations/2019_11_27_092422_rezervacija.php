<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Rezervacija extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rezervacija', function (Blueprint $table) {
            $table->integer('ID_rezervacije')->autoIncrement();
            $table->string('ID_vozila',17);
            $table->string('Ime_prezime_kupca',100);
            $table->string('Email',50);
            $table->string('Broj_telefona',20);
            $table->date('Datum_pocetka');
            $table->date('Datum_zavrsetka');
            $table->decimal('Cena',10,2);
            $table->boolean('Aktivna');
            $table->text('Napomena');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rezervacija');
    }
}
