<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoviAutomobilaModel;
use App\AutomobiliModel;

class CarController extends Controller
{
    //fomra u kojoj se odredjuje kog modela ce biti novi automobil
    public function getAdd()
    {
        $models=TipoviAutomobilaModel::all();
        return view('baza.carFormaDodaj',['models'=>$models]);
    }

    //dodavanje novog automobila
    public function add(Request $request)
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

    //stranica za formu za izmenu automobila
    public function getChange()
    {
        return view('baza.carModelID');
    }

    //funkcija u kojoj se odredi koji tacno automobil se menja i vraca stranicu sa formom za izmenu
    public function getFormChange(Request $request)
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

    //funkcija za izmenu automobila
    public function change(Request $request)
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
