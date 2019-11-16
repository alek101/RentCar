<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarInfoController extends Controller
{
    //funkcije koje vracaju stranice

    //Daje automobile koji moraju uskoro da imaju servis
    public function kriticni()
    {
        $niz=DB::select("SELECT
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
        `Servis`=0 and `Aktivan`=1 and
         (DATEDIFF(`Datum_vazenja_registracije`,CURRENT_DATE())<=? OR
         `Predjena_km`-`Radjen_mali_servis_km`>=? OR
         `Predjena_km`-`Radjen_veliki_servis_km`>=?)",[30,10000,100000]);
        
        return view('kriticni.kriticni',['niz'=>$niz]);
    }

    //zakazivanje servisa
    public function initiateServis($id)
    {
        return view('kriticni.zakaziServis',['id'=>$id]);
    }

    //trazenje pogodnog datuma za servis
    public function findServiseDate(Request $request )
    {
        $id=$request->id;
        $brojDana=$request->brojDana;
        if($brojDana>0)
        {
        $dateStart=$this->findNextFreeDate($id,$brojDana);
        $dateEnd=date('Y-m-d', strtotime($dateStart." + $brojDana days"));

        return view('kriticni.zakaziServis2',["id"=>$id,"dateStart"=>$dateStart,"dateEnd"=>$dateEnd]);
        }
        else
        {
            return $this->kriticni();
        }
    }

    //i konacno zakazivanje istog
    public function sheduleServise(Request $request )
    {
        $id=$request->id;
        $dateStart=$request->dateStart;
        $dateEnd=$request->dateEnd;

        $check=$this->freeCar($id,$dateStart,$dateEnd);
        
        if($check)
        {
         DB::transaction(function() use($id,$dateStart,$dateEnd)
         {
                $this->changeCarServis($id);
                $this->insertReservation($id,'ADMIN','ADMIN','ADMIN',$dateStart,$dateEnd,'SERVIS',0);
         },5);
        
        return $this->kriticni();
        //end transakcija
        }
        else
        {
            return view('kriticni.zakaziServis2',["id"=>$id,"dateStart"=>$dateStart,"dateEnd"=>$dateEnd]);
        }
    }

    //Strana za sve automobile
    public function auto()
    {
        $niz=$this->getAllCars();
        return view('auto.auto',['niz'=>$niz]);
    }

    //informacije o jednom autu
    public function autoInfo($id)
    {
        $auto=$this->getOneCar($id);
        $knjizica=$this->servisnaKnjizica($id);
        $niz=$this->getFutureReservationCar($id);
        return view('auto.info',['auto'=>$auto[0],'knjizica'=>$knjizica, 'niz'=>$niz]);
    }

    //pomocne funkcije I reda

    //pomocna funkcija koja daje sledeci slobodan datum
    public function findNextFreeDate($id,$brojDana)
    {
        if($brojDana>=1)
        {
            $check=false;
            $trenutniDatum=date("Y-m-d");
            $dateStart=$trenutniDatum;
            $dateEnd=date('Y-m-d', strtotime($dateStart." + $brojDana days"));
            $brojac=0;
            while($check==false and $brojac<1000)
            {
                if($this->freeCar($id,$dateStart,$dateEnd))
                {
                    $check=true;
                }
                else
                {
                    $dateStart=date('Y-m-d', strtotime($dateStart." + 1 days"));
                    $dateEnd=date('Y-m-d', strtotime($dateEnd." + 1 days"));
                    $brojac++;
                }
            }
            return $dateStart;
        }
    }

    //Pomocne funkcije II reda

    //pomocna fun koja daje da li je auto slobodan tog datuma ili ne
    public function freeCar($id,$dateStart,$dateEnd)
    {
        //proveravamo da li pravimo rezervaciju u proslosti
        $trenutni=date('Y-m-d');
        $check=strtotime($dateEnd) - strtotime($trenutni);
        if($check>0)
        {
            //vadimo sve rezervacije za auto u vremnskom periodu, ako neka postoji, auto nije slobodan
            $niz=DB::select(
                'SELECT
                A.Broj_sasije AS "id"
            FROM
                `automobili` AS A
            LEFT JOIN `rezervacija` AS R
            ON
                A.Broj_sasije = R.ID_vozila
            WHERE
                A.Broj_sasije=? and A.Aktivan=1
                and
                ((
                    ? >= R.Datum_pocetka AND ? < R.Datum_zavrsetka
                ) OR(
                    ? > R.Datum_pocetka AND ? <= R.Datum_zavrsetka
                ))',[$id,$dateStart,$dateStart,$dateEnd,$dateEnd]
            );

            if(count($niz)==0)
                {
                    return true;
                }
                else
                {
                    return false;
                };
        }
        else
        {
            return false;
        }  
    }

    //Menja stanje servisa, 0 nije na servisu, 1 da jeste na servisu
    function changeCarServis($id)
    {
        $val=$this->getServis($id)[0]->Servis;

        if($val==0)
        {
            $this->setServis($id,1);
        }
        else
        {
            $this->setServis($id,0);
        }
    }

    //
    function getServis($id)
        {
            return DB::select("SELECT
            `Servis`
        FROM
            `automobili`
        WHERE
            `Broj_sasije`=?",[$id]);
        }

    //
    function setServis($id,$val)
    {
        DB::update("UPDATE
        `automobili`
    SET
        `Servis` = ?
    WHERE
        `Broj_sasije`=?",[$val,$id]);
    }

    //Pravljenje rezervacije
    public function insertReservation($idVozila,$ime,$email,$telefon,$dateStart,$dateEnd,$comment,$cena)
    {
            //NEED TO ADD: check if registration is stile valid, limit future reservation for the next 14 days
            DB::insert(
            "INSERT INTO `rezervacija`(`ID_vozila`, `Ime_prezime_kupca`, `Email`, `Broj_telefona`, `Datum_pocetka`, `Datum_zavrsetka`, `Cena`, `Aktivna`, `Napomena`) 
            VALUES (?,?,?,?,?,?,?,1,?)",[$idVozila,$ime,$email,$telefon,$dateStart,$dateEnd,$cena,$comment]);
            return DB::getPdo()->lastInsertId();
    }

    //vraca sve automobile
    public function getAllCars()
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
        `Aktivan`=1
    ",[]);
    }

    //vraca podatke o jednom automobilu
    function getOneCar($id)
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
    Where
        `Broj_sasije`=?
    ",[$id]);
    }

    //vraca podatke o servisu jednog automobila
    public function servisnaKnjizica($id)
    {
        return DB::select(
            "SELECT
            `Datum` as 'datum',
            `Kilometraza` as 'km',
            `Tip_servisa` as 'tip',
            `Opis` as 'opis'
            
        FROM
            `servisna_knjizica`
        WHERE
            `ID_automobila`=?",[$id]
        );
    }

    //daj buduce rezervacije za odredjeni auto
    public function getFutureReservationCar($id)
    {
        return DB::select("SELECT
            R.`ID_rezervacije` as 'id',
            R.`Ime_prezime_kupca` as 'ime',
            R.`Email` as 'meil',
            R.`Broj_telefona` as 'telefon',
            A.`Broj_registarskih_tablica` as 'tablice',
            A.`Model` as 'model',
            R.`Datum_pocetka` as 'start',
            R.`Datum_zavrsetka` as 'finish',
            R.`Cena` as 'cena',
            R.`Napomena` as 'opis'
        FROM
            `rezervacija` as R
        join `automobili` as A on R.ID_vozila=A.Broj_sasije
        where CURRENT_DATE()<=R.`Datum_pocetka`+3 and A.Broj_sasije =?
        order by `Datum_pocetka` ASC",[$id]); 
    }
}
