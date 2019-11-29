<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoviAutomobilaModel;
use App\CenovnikModel;
use App\AutomobiliModel;
use App\Http\Resources\PomFunkResource;
use App\Http\Resources\TipoviAutomobilaResource;
use Illuminate\Support\Facades\DB;

class AdsController extends Controller
{
    //
    public function makeJSONforAds()
    {
        $json=[];
        $aktiveModels=TipoviAutomobilaResource::modeliAktivni();
        
        foreach($aktiveModels as $model)
        {
            $pom=[];
            $pom['Model']=$model->Model;
            $pom['slika']=$model->slika;
            $pom['Tip_menjaca']=$model->Tip_menjaca;
            $pom['Broj_vrata']=$model->Broj_vrata;
            $pom['Broj_torbi']=$model->Broj_torbi;
            $pom['Broj_sedista']=$model->Broj_sedista;

            $dateStart=date('Y-m-d');
            $dateEnd=date('Y-m-d', strtotime($dateStart." + 7 days"));
            $pom['cena']=PomFunkResource::totalCost($model->Model,$dateStart,$dateEnd);

            array_push($json,$pom);
        }

        return json_encode($json);
    }
}
