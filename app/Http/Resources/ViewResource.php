<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ViewResource extends JsonResource
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

    //menja izgled datuma iz yyyy-mm-dd u dd.mm.yyyy. format
    public static function dateLook($date)
    {
        $date=explode('-',$date);
        $date=array_reverse($date);
        $date=implode('.',$date).".";
        return $date;
    }


    //sledece funkcije nisu netacne, ali nisu ni optimalne
    //ovde smo greskom trazili trazeni interval unutar intervala rezervacije, umesto suprotonog
    //brzo resenje je bilo da se radi u intervalu dan po dan
    //pomocna fun koja daje da li je auto slobodan tog datuma ili ne
    //za svaki slucaj odlozicu ih ovde
    public static function freeCar2($id,$dateStart,$dateEnd)
    {
        //proveravamo da li pravimo rezervaciju u proslosti
        if((strtotime($dateEnd) - strtotime(date('Y-m-d')))>0)
        {
            $checkDate=$dateStart;

            while((strtotime($dateEnd) - strtotime($checkDate))>0)
            {
                if(ViewResource::freeCarSingleDay($id,$checkDate)===false)
                {
                    return false;
                }
                $checkDate=date('Y-m-d', strtotime($checkDate." + 1 days"));
            }
            return true;
        }
        else
        {
            return false;
        }  
    }

    // //da li je auto slobodnan jednog dana
    public static function freeCarSingleDay($id,$date)
    {
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
                ) )',[$id,$date,$date]
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
}
