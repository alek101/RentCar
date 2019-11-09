<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoviAutomobilaModel;
use App\CenovnikModel;


class TipoviAutomobilaController extends Controller
{
    //
    public function modeli1()
    {
        $models=TipoviAutomobilaModel::all();
        return view('auto.modeli', ['models'=>$models]);
    }

    public function modeli2()
    {
        $models=TipoviAutomobilaModel::all();
        return view('klient.sviModeli', ['models'=>$models]);
    }

    //
    public function getDodaj()
    {
        return view('baza.formaDodaj');
    }

    //
    public function dodaj(Request $request)
    {
        $newModel=new TipoviAutomobilaModel;
        $newModel->Model=$request->Model;
        $newModel->slika='/images/'.$request->slika;
        $newModel->Klasa=$request->Klasa;
        $newModel->Tip_menjaca=$request->Tip_menjaca;
        $newModel->Broj_sedista=$request->Broj_sedista;
        $newModel->Broj_vrata=$request->Broj_vrata;
        $newModel->Broj_torbi=$request->Broj_torbi;
        $newModel->opis=$request->opis;

        $newCena1=new CenovnikModel;
        $newCena1->Model=$request->model;
        $newCena1->Max_broj_dana=3;
        if($request->cena_3>0)
        {
        $newCena1->cena_po_danu=$request->cena_3;    
        }
        
        $newCena2=new CenovnikModel;
        $newCena2->Model=$request->model;
        $newCena2->Max_broj_dana=7;
        if($request->cena_7>0)
        {
        $newCena1->cena_po_danu=$request->cena_7;    
        }

        $newCena3=new CenovnikModel;
        $newCena3->Model=$request->model;
        $newCena3->Max_broj_dana=12700;
        if($request->cena_max>0)
        {
        $newCena1->cena_po_danu=$request->cena_max;    
        }

        //treba transakcija
        $newModel->saveOrFail();
        $newCena1->saveOrFail();
        $newCena2->saveOrFail();
        $newCena3->saveOrFail();

        return redirect('/auto/sviModeli');
    }
}
