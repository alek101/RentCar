<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cenovnik extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cenovnik', function (Blueprint $table) {
            $table->integer('ID')->autoIncrement();
            $table->string('Model',50);
            $table->smallInteger('Max_broj_dana');
            $table->decimal('cena_po_danu',10,2);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cenovnik');
    }
}
