<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoviAutomobilaModel;
use App\CenovnikModel;
use App\AutomobiliModel;
use App\Http\Resources\TipoviAutomobilaResource;
use Illuminate\Support\Facades\DB;


class TipoviAutomobilaController extends Controller
{
    //vraca spisak svih modela (tipova) automobila
    public function modeliSvi()
    {
        $models=TipoviAutomobilaModel::all();
        $cenovnik=CenovnikModel::all();
        return view('auto.modeli', ['models'=>$models,'cenovnik'=>$cenovnik]);
    }

    //pravi stranicu sa aktivnim mdelima
    public function modeliAktivniStranica()
    {
        $models=TipoviAutomobilaResource::modeliAktivni();
        $cenovnik=CenovnikModel::all();
        return view('klient.sviModeli', ['models'=>$models,'cenovnik'=>$cenovnik]);
    }

    //stranica za dodavanje novog tipa
    public function getAdd()
    {
        return view('baza.formaDodaj');
    }

    //funkcija za dodavanje novog tipa
    public function add(Request $request)
    {
        $request->validate([
            'slika' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $newModel=new TipoviAutomobilaModel;
        $newModel->Model=$request->Model;
        $imeSlike=$_FILES['slika']['name']; //ime slike, ['slika'] je ime inputa
        $newModel->slika='/images/'.$imeSlike;
        $newModel->Klasa=$request->Klasa;
        $newModel->Tip_menjaca=$request->Tip_menjaca;
        $newModel->Broj_sedista=$request->Broj_sedista;
        $newModel->Broj_vrata=$request->Broj_vrata;
        $newModel->Broj_torbi=$request->Broj_torbi;
        $newModel->opis=$request->opis;

        //zajedno uz nov model dodajemo i cene za tri kriterijuma po broju dana
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

        //prebacivanje slike move(putanja, ime)
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
        

        return redirect('/admin/sviModeli');
    }

    //forma u kojoj se odlucuje koji ce se model menjati
    public function getChange()
    {
        $models=TipoviAutomobilaModel::all();
        return view('baza.modelID',['models'=>$models]);
    }

    //forma koja sluzi za azuriranje modela
    public function getFormChange(Request $request)
    {
        $modelID=str_replace("_"," ",$request->Model);
        $model=TipoviAutomobilaModel::where('Model',$modelID)->firstOrFail();
        $cena_3=CenovnikModel::where('Model',$modelID)->where('Max_broj_dana',3)->firstOrFail();
        $cena_7=CenovnikModel::where('Model',$modelID)->where('Max_broj_dana',7)->firstOrFail();
        $cena_max=CenovnikModel::where('Model',$modelID)->where('Max_broj_dana',12700)->firstOrFail();
        return view('baza.formaIzmeni',['model'=>$model,'cena_3'=>$cena_3,'cena_7'=>$cena_7,'cena_max'=>$cena_max]);
    }

    //funkcija koja azurira model
    public function change(Request $request)
    {
        $model=str_replace("_"," ",$request->Model);
        $newModel=TipoviAutomobilaModel::where('Model',$model)->firstOrFail();

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

        $newCena3=CenovnikModel::where('Model',$model)->where('Max_broj_dana',12700)->firstOrFail();
        if($request->cena_max>0)
        {
        $newCena3->cena_po_danu=$request->cena_max;    
        }

        //ako menjamo sliku, dodaj je
        if(isset($request->slika))
        {
            $request->validate([
                'slika' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imeSlike=$_FILES['slika']['name'];
            $newModel->slika='/images/'.$imeSlike;
            $request->slika->move(public_path('images'), $imeSlike);
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
        
        return redirect('/admin/sviModeli');
    }
}
