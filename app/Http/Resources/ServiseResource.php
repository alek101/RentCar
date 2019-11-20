<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class ServiseResource extends JsonResource
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

    //automobili na servisu
    public static function getAllCarsServis()
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
    public static function insertServis($id,$datum,$km,$tip,$opis)
    {
        DB::insert("INSERT INTO `servisna_knjizica`(`ID_automobila`, `Datum`, `Kilometraza`, `Tip_servisa`, `Opis`) 
            VALUES (?,?,?,?,?)",[$id,$datum,$km,$tip,$opis]);
    }

    //
    public static function setMaliServisKm($id,$km)
    {
        DB::update("
        UPDATE `automobili`
        SET `Radjen_mali_servis_km`=?
        where `Broj_sasije`=?
        ",[$km,$id]);
    }

    //
    public static function setVelikiServisKM($id,$km)
    {
        DB::update("
        UPDATE `automobili`
        SET `Radjen_veliki_servis_km`=?
        where `Broj_sasije`=?
        ",[$km,$id]);
    }

    //
    public static function setRegistracija($id,$newDate)
    {
        DB::update(
        "
        UPDATE `automobili`
        SET `Datum_vazenja_registracije`=?
        where `Broj_sasije`=?
        ",[$newDate,$id]);
    }

    //dodaje kilometrazu
    public static function addKM($id,$km)
    {
        $predjena=ServiseResource::getKM($id)[0]->km;
        $nova=$predjena+$km;
        ServiseResource::setKM($id,$nova);
    }

    //
    public static function getKM($id)
    {
        return DB::select("SELECT
        `Predjena_km` as 'km'
    FROM
        `automobili`
    WHERE
        `Broj_sasije`=?",[$id]);
    }
    
    //
    public static function setKM($id,$km)
    {
        DB::update("
            UPDATE `automobili`
            SET `Predjena_km`=?
            where `Broj_sasije`=?
            ",[$km,$id]);   
    }

    //vraca broj sasije u odnosu na broj tablica
    public static function getID($tablica)
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
