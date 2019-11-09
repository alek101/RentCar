<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RezervacijaModel extends Model
{
    //
    protected $table='rezervacija';
    protected $primaryKey='ID_rezervacije';
    public $timestamps = false;
}
