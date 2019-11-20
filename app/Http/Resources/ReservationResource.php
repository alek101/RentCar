<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class ReservationResource extends JsonResource
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

    //svi automobili koji smeju da se rezervisu
    public static function aveilibleCars($dateStart,$dateEnd)
    {
        $automobili=PomFunkResource::getAllCars();
        $rezultat=[];
        foreach($automobili as $auto)
        {
            if(PomFunkResource::freeCar($auto->sasija,$dateStart,$dateEnd) and ReservationResource::checkExparationReg($auto->sasija,$dateEnd))
            {
                $model=$auto->model;
                if(!isset($rezultat[$model]))
                {
                    $rezultat[$model]=[$auto->sasija];
                }
                else
                {
                    array_push($rezultat[$model],$auto->sasija);
                }
            }
        }
        return $rezultat;
    }

    //spisak rezervacija po broju
    //$krit='DESC' or $krit='ASC'
    public static function getAllReservationsNum($num,$krit='DESC')
    {
        return DB::select(
            "SELECT
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
        order by `Datum_pocetka` ".$krit."
        LIMIT ?",[$num]);   
    }

    //spisak rezervacija u vremenskom okviru
    //$krit='DESC' or $krit='ASC'
    public static function getReservationsDate($dateStart,$dateEnd,$krit='DESC')
    {
        return DB::select(
            "SELECT
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
        where ((R.`Datum_pocetka` >=? and R.`Datum_pocetka` <=?) and (R.`Datum_zavrsetka` >=? and R.`Datum_zavrsetka` <=?))
        order by `Datum_pocetka` ".$krit."
        ",[$dateStart,$dateEnd,$dateStart,$dateEnd]);   
    }

    //pomocna funkcija koja proverava da li auto sme da se rezervise
    public static function checkExparationReg($id,$dateEnd,$crit_time=3)
    {
        $razlika=DB::select(
            "SELECT
            DATEDIFF(`Datum_vazenja_registracije`,?) as razlika
        FROM
            `automobili`
        WHERE
            `Broj_sasije`=?",[$dateEnd,$id])[0];

        if($razlika->razlika>=$crit_time)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //informacije o rezervaciji
    public static function returnInformation($idRezervacije)
    {
        $pom=DB::select(
        "SELECT
        `ID_rezervacije` as 'id_rez',
        `Ime_prezime_kupca` as 'ime',
        `Email` as 'email',
        `Broj_telefona` as 'telefon',
        `Datum_pocetka` as 'dateStart',
        `Datum_zavrsetka` as 'dateEnd',
        `Broj_registarskih_tablica` as 'tablice',
        `Model` as 'model',
        `Cena` as 'cena',
        A.Broj_sasije as 'car_id',
        `Napomena` as 'opis'
        FROM
            `rezervacija` AS R
        JOIN `automobili` AS A
        ON
            R.ID_vozila = A.Broj_sasije
        WHERE
            `ID_rezervacije` = ?",[$idRezervacije]);
            return $pom[0];
    }

    //otkazivanje rezervacije u bazi
    public static function cancelFutureReservation($id)
    {
        DB::delete("DELETE
        FROM
            `rezervacija`
        WHERE
            `ID_rezervacije`=? and CURRENT_DATE()<=`Datum_pocetka`+3",[$id]);
    }

    //azuriranje rezervacija
    public static function updateReservation($newDateEnd,$newCost,$id)
    {
        DB::update(
            "
            UPDATE `rezervacija` 
            SET `Datum_zavrsetka` = ?, 
            `Cena`=? 
            WHERE `rezervacija`.`ID_rezervacije` = ?
            ",[$newDateEnd,$newCost,$id]
        );
    }

    //Funkcija koja salje mejl kupcu-trenutno je iskljucena da ne bi bagovala
    public static function sendMeil($info,$tip='new')
        {

        //     if($tip=='new')
        //     {
        //         $naslov="Uspesna rezervacija";
        //         $poruka="Uspesno ste rezervisali auto $info->model sa registarskim tablicama $info->tablice na ime: $info->ime
        //         , u vremenskom periodu od $info->dateStart do $info->dateEnd. Broj Vase rezervacije je $info->id_rez. Ukupna cena je $info->cena.";
        //         $poruka=wordwrap($poruka,70,"\n");
        //         mail($info->email,$naslov,$poruka);
        //     }

        //     if($tip=='extend')
        //     {
        //         $naslov="Uspesno produznje";
        //         $poruka="Uspesno ste produzili rezervaciju automobila $info->model sa registarskim tablicama $info->tablice na ime: $info->ime
        //         , u novom vremenskom periodu od $info->dateStart do $info->dateEnd. Broj Vase rezervacije je $info->id_rez. Nova cena je $info->cena.";
        //         $poruka=wordwrap($poruka,70,"\n");
        //         mail($info->email,$naslov,$poruka);
        //     }

        //     if($tip=='shortend')
        //     {
        //         $naslov="Uspesno skracenje";
        //         $poruka="Uspesno ste skratili rezervaciju automobila $info->model sa registarskim tablicama $info->tablice na ime: $info->ime
        //         , u novom vremenskom periodu od $info->dateStart do $info->dateEnd. Broj Vase rezervacije je $info->id_rez. Nova cena je $info->cena.";
        //         $poruka=wordwrap($poruka,70,"\n");
        //         mail($info->email,$naslov,$poruka);
        //     }

        //     if($tip=='cancel')
        //     {
        //         $naslov="Rezervaicja je ukinuta";
        //         $poruka="Rrezervaciju automobila $info->model sa registarskim tablicama $info->tablice na ime: $info->ime
        //         , u novom vremenskom periodu od $info->dateStart do $info->dateEnd je ukinuta. Broj Vase rezervacije je $info->id_rez.";
        //         $poruka=wordwrap($poruka,70,"\n");
        //         mail($info->email,$naslov,$poruka);
        //     }
        }
}
