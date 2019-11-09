<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoviAutomobilaModel;
use App\AutomobiliModel;

class CarController extends Controller
{
    //
    public function getDodaj()
    {
        $models=TipoviAutomobilaModel::all();
        return view('baza.carFormaDodaj',['models'=>$models]);
    }

    //
    public function dodaj(Request $request)
    {
        $newCar=new AutomobiliModel;
        $newCar->Broj_sasije=$request->Broj_sasije;
        $newCar->Broj_saobracajne_dozvole=$request->Broj_saobracajne_dozvole;
        $newCar->Broj_registarskih_tablica=$request->Broj_registarskih_tablica;
        $newCar->Godina_proizvodnje=$request->Godina_proizvodnje;
        $newCar->Datum_vazenja_registracije=$request->Datum_vazenja_registracije;
        $newCar->Predjena_km=$request->Predjena_km;
        $newCar->Radjen_mali_servis_km=$request->Radjen_mali_servis_km;
        $newCar->Radjen_veliki_servis_km=$request->Radjen_veliki_servis_km;
        $newCar->Servis=$request->Servis;
        $newCar->Aktivan=$request->Aktivan;
        $newCar->Model=str_replace("_"," ",$request->Model);
        $newCar->saveOrFail();
        return redirect('/auto');
    }

    //
    public function getIzmeni()
    {
        return view('baza.carModelID');
    }

    //
    public function getFormIzmeni(Request $request)
    {
        $models=TipoviAutomobilaModel::all();

        if(isset($request->Broj_sasije))
        {
            $car=AutomobiliModel::where('Broj_sasije',$request->Broj_sasije)->firstOrFail();
            return view('baza.carFormaIzmeni',['car'=>$car,'models'=>$models]);
        }

        if(isset($request->Broj_registarskih_tablica))
        {
            $car=AutomobiliModel::where('Broj_registarskih_tablica',$request->Broj_registarskih_tablica)->firstOrFail();
            return view('baza.carFormaIzmeni',['car'=>$car,'models'=>$models]);
        }

        return redirect('/baza/change2');
    }

    //
    public function izmeni(Request $request)
    {
        $newCar=AutomobiliModel::where('Broj_sasije',$request->Broj_sasije)->firstOrFail();
        $newCar->Broj_sasije=$request->Broj_sasije;
        $newCar->Broj_saobracajne_dozvole=$request->Broj_saobracajne_dozvole;
        $newCar->Broj_registarskih_tablica=$request->Broj_registarskih_tablica;
        $newCar->Godina_proizvodnje=$request->Godina_proizvodnje;
        $newCar->Datum_vazenja_registracije=$request->Datum_vazenja_registracije;
        $newCar->Predjena_km=$request->Predjena_km;
        $newCar->Radjen_mali_servis_km=$request->Radjen_mali_servis_km;
        $newCar->Radjen_veliki_servis_km=$request->Radjen_veliki_servis_km;
        $newCar->Servis=$request->Servis;
        $newCar->Aktivan=$request->Aktivan;
        $newCar->Model=str_replace("_"," ",$request->Model);
        $newCar->saveOrFail();
        return redirect('/auto');
    }
}
