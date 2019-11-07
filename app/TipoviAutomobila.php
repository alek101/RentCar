<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoviAutomobila extends Model
{
    //
    protected $table='model';
    protected $primaryKey='Model';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    
}
