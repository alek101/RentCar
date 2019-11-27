<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ServisnaKnjizica extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servisna_knjizica', function (Blueprint $table) {
            $table->integer('ID')->autoIncrement();
            $table->string('ID_automobila',17);
            $table->date('Datum');
            $table->integer('Kilometraza');
            $table->enum('Tip_servisa',array('mali','veliki'));
            $table->text('Opis');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servisna_knjizica');
    }
}
