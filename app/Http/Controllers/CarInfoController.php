<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\HTTP\Resources\PomFunkResource;
use App\HTTP\Resources\CarInfoResource;

class CarInfoController extends Controller
{
    //Daje automobile koji moraju uskoro da imaju servis
    public function kriticni()
    {
        $niz=CarInfoResource::getCriticalCars();
        return view('kriticni.kriticni',['niz'=>$niz]);
    }

    //zakazivanje servisa
    public function initiateServis($id)
    {
        return view('kriticni.zakaziServis',['id'=>$id]);
    }

    //trazenje pogodnog datuma za servis
    public function findServiseDate(Request $request )
    {
        $request->validate([
            'id'=>'required',
            'brojDana'=>'required',
        ]);

        $id=$request->id;
        $brojDana=$request->brojDana;
        if($brojDana>0)
        {
        $dateStart=CarInfoResource::findNextFreeDate($id,$brojDana);
        $dateEnd=date('Y-m-d', strtotime($dateStart." + $brojDana days"));

        return view('kriticni.zakaziServis2',["id"=>$id,"dateStart"=>$dateStart,"dateEnd"=>$dateEnd]);
        }
        else
        {
            return $this->kriticni();
        }
    }

    //i konacno zakazivanje istog
    public function sheduleServise(Request $request )
    {
        $request->validate([
            'id'=>'required',
            'dateStart'=>'required|date',
            'dateEnd'=>'required|date',
        ]);

        $id=$request->id;
        $dateStart=$request->dateStart;
        $dateEnd=$request->dateEnd;
        
        if(PomFunkResource::freeCar($id,$dateStart,$dateEnd))
        {
         DB::transaction(function() use($id,$dateStart,$dateEnd)
         {
                PomFunkResource::changeCarServis($id);
                PomFunkResource::insertReservation($id,'ADMIN','ADMIN','ADMIN',$dateStart,$dateEnd,'SERVIS',0);
         },5);
        
        return $this->kriticni();
        //end transakcija
        }
        else
        {
            return view('kriticni.zakaziServis2',["id"=>$id,"dateStart"=>$dateStart,"dateEnd"=>$dateEnd]);
        }
    }

    //Strana za sve automobile
    public function auto()
    {
        $niz=PomFunkResource::getAllCars();
        return view('auto.auto',['niz'=>$niz]);
    }

    //Strana za neaktivne automobile
    public function unactiveAuto()
    {
        $niz=PomFunkResource::getAllCars(0);
        return view('admin.unactiveAuto',['niz'=>$niz]);
    }

    //informacije o jednom autu
    public function autoInfo($id)
    {
        $auto=CarInfoResource::getOneCar($id);
        $knjizica=CarInfoResource::servisnaKnjizica($id);
        $niz=CarInfoResource::getFutureReservationCar($id);
        return view('auto.info',['auto'=>$auto[0],'knjizica'=>$knjizica, 'niz'=>$niz]);
    }
}
