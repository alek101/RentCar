<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\HTTP\Resources\PomFunkResource;
use App\HTTP\Resources\ServiseResource;

class ServiseController extends Controller
{
    //funkcije koje vracaju stranice

    //automobili na servisu
    public function servis()
    {
        $niz=ServiseResource::getAllCarsServis();
        
        return view('servis.servis',['niz'=>$niz]);
    }

    //vraca stranicu iz servisa gde se upisuje servsne informacije u knjizicu
    public function servisCar($id)
    {
        return view('servis.uradi',['id'=>$id]);
    }

    //funkcija koja vraca stranicu za dodavanje km
    public function prijem()
    {
        return view('prijem.prijem');
    }

    //Pomocne funkcije I reda

    //funkcija koja prima podatke za zavrsetak servisa
    public function endServis(Request $request)
    {
        $id=$request->id;
        $tip=$request->tip;
        $datum=$request->datum;
        $opis=$request->opis;
        $registracija=$request->registracija;
        $this->madeServis($id,$tip,$datum,$opis,$registracija);
        return $this->servis();
    }

    //pomocna funkcija koja radi servis
    function madeServis($id,$tip,$datum,$opis,$registracija)
    {
        $km=ServiseResource::getKM($id)[0]->km;

        if($tip=='mali')
        {
            DB::transaction(function() use($id,$datum,$opis,$km)
            {
                ServiseResource::insertServis($id,$datum,$km,'mali',$opis);
                ServiseResource::setMaliServisKM($id,$km);
                PomFunkResource::changeCarServis($id);
            },5);
            
        }
        if($tip=='veliki')
        {
            DB::transaction(function() use($id,$datum,$opis,$km)
            {
                ServiseResource::insertServis($id,$datum,$km,'mali',$opis);
                ServiseResource::setMaliServisKM($id,$km);
                ServiseResource::setVelikiServisKM($id,$km);
                PomFunkResource::changeCarServis($id);
            },5);
            
        }
        // if ($tip=='cancel')
        // {
        //     PomFunkResource::changeCarServis($id);
        // }
        if($tip=='registracija')
        {
            DB::transaction(function() use($id,$registracija)
            {
                ServiseResource::setRegistracija($id,$registracija);
                PomFunkResource::changeCarServis($id);
            },5);
        }
    }

    //funkcija za dodavanje km automobilu
    public function izmeniKM(Request $request)
    {
        $id=$request->id;
        $tablica=$request->tablica;
        $km=$request->km;

        if(isset($id) and $km>0)
        {
            ServiseResource::addKM($id,$km);
            return Redirect('/auto/info/'.$id);
        }
        if(isset($tablica) and $km>0)
        {
            $id=ServiseResource::getID($tablica);
            ServiseResource::addKM($id,$km);
            return $this->prijem();
        }
    }
}
