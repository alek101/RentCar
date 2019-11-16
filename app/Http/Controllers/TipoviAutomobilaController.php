<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoviAutomobilaModel;
use App\CenovnikModel;
use Illuminate\Support\Facades\DB;


class TipoviAutomobilaController extends Controller
{
    //depricated
    public function modeli1()
    {
        $models=TipoviAutomobilaModel::all();
        return view('auto.modeli', ['models'=>$models]);
    }

    public function modeli2()
    {
        $models=TipoviAutomobilaModel::all();
        $cenovnik=CenovnikModel::all();
        return view('klient.sviModeli', ['models'=>$models,'cenovnik'=>$cenovnik]);
    }

    //
    public function getAdd()
    {
        return view('baza.formaDodaj');
    }

    //
    public function add(Request $request)
    {
        $request->validate([
            'slika' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $newModel=new TipoviAutomobilaModel;
        $newModel->Model=$request->Model;
        $imeSlike=str_replace("_"," ",$request->slikaIme);
        $newModel->slika='/images/'.$imeSlike;
        $newModel->Klasa=$request->Klasa;
        $newModel->Tip_menjaca=$request->Tip_menjaca;
        $newModel->Broj_sedista=$request->Broj_sedista;
        $newModel->Broj_vrata=$request->Broj_vrata;
        $newModel->Broj_torbi=$request->Broj_torbi;
        $newModel->opis=$request->opis;

        $newCena1=new CenovnikModel;
        $newCena1->Model=$request->Model;
        $newCena1->Max_broj_dana=3;
        if($request->cena_3>0)
        {
        $newCena1->cena_po_danu=$request->cena_3;    
        }
        
        $newCena2=new CenovnikModel;
        $newCena2->Model=$request->Model;
        $newCena2->Max_broj_dana=7;
        if($request->cena_7>0)
        {
        $newCena2->cena_po_danu=$request->cena_7;    
        }

        $newCena3=new CenovnikModel;
        $newCena3->Model=$request->Model;
        $newCena3->Max_broj_dana=12700;
        if($request->cena_max>0)
        {
        $newCena3->cena_po_danu=$request->cena_max;    
        }

        $request->slika->move(public_path('images'), $imeSlike);

        //treba transakcija
        DB::transaction(function() use($newModel,
        $newCena1,
        $newCena2,
        $newCena3)
        {
            $newModel->saveOrFail();
            $newCena1->saveOrFail();
            $newCena2->saveOrFail();
            $newCena3->saveOrFail();
        },1);
        

        return redirect('/auto/sviModeli');
    }

    //
    public function getChange()
    {
        $models=TipoviAutomobilaModel::all();
        return view('baza.modelID',['models'=>$models]);
    }

    //
    public function getFormChange(Request $request)
    {
        $modelID=str_replace("_"," ",$request->Model);
        $model=TipoviAutomobilaModel::where('Model',$modelID)->firstOrFail();
        $cena_3=CenovnikModel::where('Model',$modelID)->where('Max_broj_dana',3)->firstOrFail();
        $cena_7=CenovnikModel::where('Model',$modelID)->where('Max_broj_dana',7)->firstOrFail();
        $cena_max=CenovnikModel::where('Model',$modelID)->where('Max_broj_dana',12700)->firstOrFail();
        return view('baza.formaIzmeni',['model'=>$model,'cena_3'=>$cena_3,'cena_7'=>$cena_7,'cena_max'=>$cena_max]);
    }

    public function change(Request $request)
    {
        $model=str_replace("_"," ",$request->Model);
        $newModel=TipoviAutomobilaModel::where('Model',$model)->firstOrFail();
        $newModel->slika='/images/'.str_replace("_"," ",$request->slikaIme);
        $newModel->Klasa=$request->Klasa;
        $newModel->Tip_menjaca=$request->Tip_menjaca;
        $newModel->Broj_sedista=$request->Broj_sedista;
        $newModel->Broj_vrata=$request->Broj_vrata;
        $newModel->Broj_torbi=$request->Broj_torbi;
        $newModel->opis=$request->opis;

        $newCena1=CenovnikModel::where('Model',$model)->where('Max_broj_dana',3)->firstOrFail();
        if($request->cena_3>0)
        {
        $newCena1->cena_po_danu=$request->cena_3;    
        }
        
        $newCena2=CenovnikModel::where('Model',$model)->where('Max_broj_dana',7)->firstOrFail();
        if($request->cena_7>0)
        {
        $newCena2->cena_po_danu=$request->cena_7;    
        }

        $newCena3=CenovnikModel::where('Model',$model)->where('Max_broj_dana',7)->firstOrFail();
        if($request->cena_max>0)
        {
        $newCena3->cena_po_danu=$request->cena_max;    
        }

        //treba transakcija
        DB::transaction(function() use ($newModel,
        $newCena1,
        $newCena2,
        $newCena3)
        {
            $newModel->saveOrFail();
            $newCena1->saveOrFail();
            $newCena2->saveOrFail();
            $newCena3->saveOrFail();
        },1);
        
        return redirect('/auto/sviModeli');
    }
}
