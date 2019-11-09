<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutomobiliModel extends Model
{
    //
    protected $table='automobili';
    protected $primaryKey='Broj_sasije';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
}
