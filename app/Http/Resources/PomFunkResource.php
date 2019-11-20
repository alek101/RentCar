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
        $trenutni=date('Y-m-d');
        $check=strtotime($dateEnd) - strtotime($trenutni);
        if($check>0)
        {
            //vadimo sve rezervacije za auto u vremnskom periodu, ako neka postoji, auto nije slobodan
            $niz=DB::select(
                'SELECT
                    *
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

    //

}
