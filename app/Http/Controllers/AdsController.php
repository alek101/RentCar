<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoviAutomobilaModel;
use App\CenovnikModel;
use App\AutomobiliModel;
use App\Http\Resources\TipoviAutomobilaResource;
use Illuminate\Support\Facades\DB;

class AdsController extends Controller
{
    //
    public function makeJSONforAds()
    {
        $aktiveModels=TipoviAutomobilaResource::modeliAktivni();
        $cenovnik=$cenovnik=CenovnikModel::all();
        
    }
}
