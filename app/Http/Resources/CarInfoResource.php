<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class CarInfoResource extends JsonResource
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

    //pomocna funkcija koja daje sledeci slobodan datum
    public static function findNextFreeDate($id,$brojDana)
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
                if(PomFunkResource::freeCar($id,$dateStart,$dateEnd))
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

    //vraca podatke o jednom automobilu
    public static function getOneCar($id)
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
    public static function servisnaKnjizica($id)
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
    public static function getFutureReservationCar($id)
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

    //kriticni automobili
    public static function getCriticalCars($dayRegistratonExparation=30,$smallServise=10000,$mainServise=100000)
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
        `Servis`=0 and `Aktivan`=1 and
         (DATEDIFF(`Datum_vazenja_registracije`,CURRENT_DATE())<=? OR
         `Predjena_km`-`Radjen_mali_servis_km`>=? OR
         `Predjena_km`-`Radjen_veliki_servis_km`>=?)",[$dayRegistratonExparation,$smallServise,$mainServise]);
    }
}
