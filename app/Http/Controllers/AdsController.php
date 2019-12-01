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
    //ova funkcija pravi jednu reklamu od svakog aktivnog modela
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

            //racunamo cenu za nasumicni broj dana dana
            $dateStart=date('Y-m-d');
            $brojDana=rand(3,14);
            $pom['brojDana']=$brojDana;
            $dateEnd=date('Y-m-d', strtotime($dateStart." + ".$brojDana." days"));
            $cena=PomFunkResource::totalCost($model->Model,$dateStart,$dateEnd);
            $pom['cena']=$cena;

            array_push($cene,$cena);

            array_push($json,$pom);
        }

        array_multisort($cene,$json);

        return json_encode($json);
    }

    //ova funkcija pravi odredjeni broj reklama
    public function makeJSONforAdsFixedNumber()
    {
        //json niz
        $json=[];
        //pomocni niz kako bismo sortirali json po cenama
        $cene=[];
        //svi aktivni modeli
        $aktiveModels=TipoviAutomobilaResource::modeliAktivni();
        $i=0;
        $totalAds=6;
        $numberModels=count($aktiveModels);
        $uniqueArray=[];

        //praimo niz sa podacima potrebnim za pomocnu funkciju koja pravi ads-ove
        while($i<$totalAds)
        {
            $spec=[];
            //nasumican index niza $aktiveModels
            $spec['indexModel']=rand(0,$numberModels-1);
            //zelimo nasumicni broj dana iz niza broja dana
            $nizBrojDana=[1,3,5,7,10,14];
            $spec['brojDana']=$nizBrojDana[rand(0,count($nizBrojDana)-1)];

            //osiguravamo se da ne postoje dve iste reklame
            $check=true;

            foreach($uniqueArray as $subSection)
            {
                if($spec['indexModel']==$subSection['indexModel'] and $spec['brojDana']==$subSection['brojDana'] ) $check=false;
            }

           if($check)
           {
               array_push($uniqueArray,$spec);
               $i++;
           }
        }

        //pravimo niz
        foreach($uniqueArray as $var)
        {
            $singleAd=$this->makeSingleAd($aktiveModels[$var['indexModel']],$var['brojDana']);
            array_push($json,$singleAd);
            array_push($cene,$singleAd['cena']);
        }

        array_multisort($cene,$json);

        return json_encode($json); 
    }

    //pomocna funkcija
    public function makeSingleAd($model,$brojDana)
    {
        $pom=[];
        $pom['Model']=$model->Model;
        $pom['slika']=$model->slika;
        $pom['Tip_menjaca']=$model->Tip_menjaca;
        $pom['Broj_vrata']=$model->Broj_vrata;
        $pom['Broj_torbi']=$model->Broj_torbi;
        $pom['Broj_sedista']=$model->Broj_sedista;
        $pom['brojDana']=$brojDana;
        //racunamo cenu za broj dana dana
        $dateStart=date('Y-m-d');
        $dateEnd=date('Y-m-d', strtotime($dateStart." + ".$brojDana." days"));
        $cena=PomFunkResource::totalCost($model->Model,$dateStart,$dateEnd);
        $pom['cena']=$cena;
        return $pom;
    }
}
