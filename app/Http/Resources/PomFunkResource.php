<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class PomFunkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    //Pravljenje rezervacije
    public static function insertReservation($idVozila,$ime,$email,$telefon,$dateStart,$dateEnd,$comment,$cena)
    {
            DB::insert(
            "INSERT INTO `rezervacija`(`ID_vozila`, `Ime_prezime_kupca`, `Email`, `Broj_telefona`, `Datum_pocetka`, `Datum_zavrsetka`, `Cena`, `Aktivna`, `Napomena`) 
            VALUES (?,?,?,?,?,?,?,1,?)",[$idVozila,$ime,$email,$telefon,$dateStart,$dateEnd,$cena,$comment]);
            return DB::getPdo()->lastInsertId();
    }

    //pomocna fun koja daje da li je auto slobodan tog datuma ili ne
    public static function freeCar($id,$dateStart,$dateEnd)
    {
        //proveravamo da li pravimo rezervaciju u proslosti
        if((strtotime($dateEnd) - strtotime(date('Y-m-d')))>0)
        {
            //vadimo sve rezervacije za auto u vremnskom periodu, ako neka postoji, auto nije slobodan
            //svaka rezervacija ima svoj sopstveni vremenski period
            //mi proveravamo za neki ukupni trazeni period i prodpostavljamo da ne postoji ni jedna rezervacija u njemu
            //u tom ukupnom trazenom periodu, pocetak i kraj svake rezervacije ne sme da postoji, sto znaci da interval trjanja rezervacije ne sme da bude
            //sadrzan u trazenom intervalu
            //jer ako postoji, onda znaci da u tom trazenom intervalu postoji barem jedna rezervacija, sto je suprotno predpostavci
            //granicni slucajevi su posebni, jer rezervacija moze da pocne istoga dana kada se predhodna zavrsi
            //sto znaci da intervali rezervacije ne smeju da budu na pocetku, ili kraju unutar ukupnog trazenog intervala, ali smeju da budu sa spoljen strane

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
                    R.Datum_pocetka >=? AND  R.Datum_pocetka <?
                ) OR (
                    R.Datum_zavrsetka >? AND  R.Datum_zavrsetka <=?
                ))',[$id,$dateStart,$dateEnd,$dateStart,$dateEnd]
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

    //funkcija za racunanje cene rezervacije u zavisnosti od modela i duzine trajanja rezervacije
    public static function totalCost($model,$dateStart,$dateEnd)
    {
        $niz=DB::select("
        SELECT `cena_po_danu` AS 'cena', DATEDIFF(?, ?) as 'razlika' 
        FROM `cenovnik` WHERE 
        `Model` = ? AND `Max_broj_dana` >= DATEDIFF(?, ?)",[$dateEnd,$dateStart,$model,$dateEnd,$dateStart]);

        $max=0;
        foreach($niz as $clan)
        {
            if($clan->cena>$max)
            {
                $max=$clan->cena;
            }
        }
        return $niz[0]->razlika*$max;
    }

    //vraca sve automobile u zavisnosti da li su aktivni ili obrisani
    public static function getAllCars($aktivan=1)
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
        `Aktivan`=?
    ",[$aktivan]);
    }

    //Menja stanje servisa, 0 nije na servisu, 1 da jeste na servisu
    public static function changeCarServis($id)
    {
        $pre_val=PomFunkResource::getServis($id);
        if(count($pre_val)!=1)
        {
            return redirect('/kriticni');
        }
        
        $val=$pre_val[0]->Servis;

        if($val==0)
        {
            PomFunkResource::setServis($id,1);
        }
        else
        {
            PomFunkResource::setServis($id,0);
        }
    }

    //vraca podatak da li je auto na servisu
    public static function getServis($id)
        {
            return DB::select("SELECT
            `Servis`
        FROM
            `automobili`
        WHERE
            `Broj_sasije`=?",[$id]);
        }

    //menja podatak da li je auto na sevisu
    public static function setServis($id,$val)
    {
        DB::update("UPDATE
        `automobili`
    SET
        `Servis` = ?
    WHERE
        `Broj_sasije`=?",[$val,$id]);
    }
}
