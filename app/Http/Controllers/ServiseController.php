<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\HTTP\Resources\PomFunkResource;
use App\HTTP\Resources\ServiseResource;

class ServiseController extends Controller
{
    //vraca stranicu za automobile na servisu
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

    //funkcija koja prima podatke za zavrsetak servisa
    public function endServis(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'tip'=>'required',
        ]);

        $id=$request->id;
        $tip=$request->tip;

        if($tip=='mali' or $tip=='veliki')
        {
            $request->validate([
                'datum'=>'required|date',
                'opis'=>'required',
            ]);
        }

        if($tip=='registracija')
        {
            $request->validate([
                'registracija'=>'required|date',
            ]);
        }

        $datum=$request->datum;
        $opis=$request->opis;
        $registracija=$request->registracija;
        ServiseResource::madeServis($id,$tip,$datum,$opis,$registracija);
        return $this->servis();
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

        return back();
    }
}
