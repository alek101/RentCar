<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CenovnikModel extends Model
{
    //
    protected $table='cenovnik';
    protected $primaryKey='ID';
    public $timestamps = false;
}
