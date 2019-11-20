<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\HTTP\Resources\PomFunkResource;

class ServiseController extends Controller
{
    //funkcije koje vracaju stranice

    //automobili na servisu
    public function servis()
    {
        $niz=$this->getAllCarsServis();
        
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
        $km=$this->getKM($id)[0]->km;

        if($tip=='mali')
        {
            DB::transaction(function() use($id,$datum,$opis,$km)
            {
                $this->insertServis($id,$datum,$km,'mali',$opis);
                $this->setMaliServisKM($id,$km);
                PomFunkResource::changeCarServis($id);
            },5);
            
        }
        if($tip=='veliki')
        {
            DB::transaction(function() use($id,$datum,$opis,$km)
            {
                $this->insertServis($id,$datum,$km,'mali',$opis);
                $this->setMaliServisKM($id,$km);
                $this->setVelikiServisKM($id,$km);
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
                $this->setRegistracija($id,$registracija);
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
            $this->addKM($id,$km);
            return Redirect('/auto/info/'.$id);
        }
        if(isset($tablica) and $km>0)
        {
            $id=$this->getID($tablica);
            $this->addKM($id,$km);
            return $this->prijem();
        }
    }

    //Pomocne funkcije II reda

    //automobili na servisu
    public function getAllCarsServis()
    {
        return DB::select("SELECT
        `Broj_sasije` as 'sasija',
        `Broj_saobracajne_dozvole` as 'saobracajna',
        `Broj_registarskih_tablica` as 'tablica',
        `Model` as 'model',
        `Godina_proizvodnje` as 'godiste',
        `Predjena_km` as 'kilometraza',
        `Datum_vazenja_registracije` as 'registracija',
        `Radjen_mali_servis_km` as 'mali_servis',
        `Radjen_veliki_servis_km` as 'veliki_servis',
        DATEDIFF(`Datum_vazenja_registracije`,CURRENT_DATE()) as 'isticanje_registracije',
        `Predjena_km`-`Radjen_mali_servis_km` as 'predjeno_km_mali',
        `Predjena_km`-`Radjen_veliki_servis_km` as 'predjeno_km_veliki'
    FROM
        `automobili`
    WHERE
        `Servis`=1 and `Aktivan`=1",[]);
    }

    //funkcija koj upisuje servis u bazu
    public function insertServis($id,$datum,$km,$tip,$opis)
    {
        DB::insert("INSERT INTO `servisna_knjizica`(`ID_automobila`, `Datum`, `Kilometraza`, `Tip_servisa`, `Opis`) 
            VALUES (?,?,?,?,?)",[$id,$datum,$km,$tip,$opis]);
    }

    //
    public function setMaliServisKm($id,$km)
    {
        DB::update("
        UPDATE `automobili`
        SET `Radjen_mali_servis_km`=?
        where `Broj_sasije`=?
        ",[$km,$id]);
    }

    //
    public function setVelikiServisKM($id,$km)
    {
        DB::update("
        UPDATE `automobili`
        SET `Radjen_veliki_servis_km`=?
        where `Broj_sasije`=?
        ",[$km,$id]);
    }

    //
    public function setRegistracija($id,$newDate)
    {
        DB::update(
        "
        UPDATE `automobili`
        SET `Datum_vazenja_registracije`=?
        where `Broj_sasije`=?
        ",[$newDate,$id]);
    }

    //dodaje kilometrazu
    public function addKM($id,$km)
    {
        $predjena=$this->getKM($id)[0]->km;
        $nova=$predjena+$km;
        $this->setKM($id,$nova);
    }

    //
    function getKM($id)
    {
        return DB::select("SELECT
        `Predjena_km` as 'km'
    FROM
        `automobili`
    WHERE
        `Broj_sasije`=?",[$id]);
    }
    
    //
    public function setKM($id,$km)
    {
        DB::update("
            UPDATE `automobili`
            SET `Predjena_km`=?
            where `Broj_sasije`=?
            ",[$km,$id]);   
    }

    //vraca broj sasije u odnosu na broj tablica
    public function getID($tablica)
    {
        return DB::select(
            "
            SELECT
            `Broj_sasije`as 'id'
            FROM
                `automobili`
            WHERE
                `Broj_registarskih_tablica`=?
            ",[$tablica]
        )[0]->id;
    }

}
