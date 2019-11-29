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
        //pomocni niz kako bismo sortirali json po cenama
        $cene=[];
        $aktiveModels=TipoviAutomobilaResource::modeliAktivni();
        
        foreach($aktiveModels as $model)
        {
            //napravimo json sa podacima koji nam trebaju
            $pom=[];
            $pom['Model']=$model->Model;
            $pom['slika']=$model->slika;
            $pom['Tip_menjaca']=$model->Tip_menjaca;
            $pom['Broj_vrata']=$model->Broj_vrata;
            $pom['Broj_torbi']=$model->Broj_torbi;
            $pom['Broj_sedista']=$model->Broj_sedista;

            //racunamo cenu za 7 dana
            $dateStart=date('Y-m-d');
            $dateEnd=date('Y-m-d', strtotime($dateStart." + 7 days"));
            $cena=PomFunkResource::totalCost($model->Model,$dateStart,$dateEnd);
            $pom['cena']=$cena;

            array_push($cene,$cena);

            array_push($json,$pom);
        }

        array_multisort($cene,$json);

        return json_encode($json);
    }
}
