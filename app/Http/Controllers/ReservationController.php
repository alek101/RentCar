<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\TipoviAutomobilaModel;
use App\AutomobiliModel;
use App\HTTP\Resources\PomFunkResource;
use App\HTTP\Resources\ReservationResource;

class ReservationController extends Controller
{
    
    //Pravi stranicu sa svim rezervacijama sa osnovnim kriterijumom
    public function defaultReservations()
    {
        $dateStart=date('Y-m-d');
        $dateEnd=date('Y-m-d', strtotime($dateStart." + 90 days"));
        $niz=ReservationResource::getReservationsDate($dateStart,$dateEnd,'ASC');  
        return view('rezervacijeInfo.sve',['niz'=>$niz]);
    }

    //Pravi stranicu sa svim rezervacijama sa osnovnim kriterijumom
    public function getReservationsNow()
    {
        $niz=ReservationResource::getReservationsCurrent();  
        return view('rezervacijeInfo.trenutne',['niz'=>$niz]);
    }

    //forma iz rezervacija
    public function allReservationForm(Request $request)
    {
        if($request->order=="DESC")
        {
            if(isset($request->num))
            {
                $niz=ReservationResource::getAllReservationsNum($request->num,'DESC');  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }
            
            if(isset($request->dateStart) && isset($request->dateEnd))
            {
                $niz=ReservationResource::getReservationsDate($request->dateStart,$request->dateEnd,'DESC');  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }

            if(isset($request->dateStart) && !isset($request->dateEnd))
            {
                $dateEnd=date('Y-m-d', strtotime($request->dateStart." + 365 days"));
                $niz=ReservationResource::getReservationsDate($request->dateStart,$dateEnd,'DESC');  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }
            
            if(!isset($request->dateStart) && isset($request->dateEnd))
            {
                $dateStart=date('Y-m-d', strtotime($request->dateEnd." - 365 days"));
                $niz=ReservationResource::getReservationsDate($dateStart,$request->dateEnd,'DESC');  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }
        }

        if($request->order=="ASC")
        {
            if(isset($request->num))
            {
                $niz=ReservationResource::getAllReservationsNum($request->num,'ASC');  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }
            
            if(isset($request->dateStart) && isset($request->dateEnd))
            {
                $niz=ReservationResource::getReservationsDate($request->dateStart,$request->dateEnd,'ASC');  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }

            if(isset($request->dateStart) && !isset($request->dateEnd))
            {
                $dateEnd=date('Y-m-d', strtotime($request->dateStart." + 365 days"));
                $niz=ReservationResource::getReservationsDate($request->dateStart,$dateEnd,'ASC');  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }
            
            if(!isset($request->dateStart) && isset($request->dateEnd))
            {
                $dateStart=date('Y-m-d', strtotime($request->dateEnd." - 365 days"));
                $niz=ReservationResource::getReservationsDate($dateStart,$request->dateEnd,'ASC');  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }
        }
            
        return $this->allReservations();
    }   

    //stranica za produzenje rezervacije
    public function getExtendForm($id)
    {
        return view('rezervacijeInfo.extendForm',['id'=>$id]);
    }

    //produzenje rezervacije
    public function extendReservation(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'brojDana'=>'required',
        ]);
        
        $id=$request->id;
        $brojDana=$request->brojDana;
        $rezervacija=ReservationResource::returnInformation($id);
        $dateStart=$rezervacija->dateStart;
        $dateEnd=$rezervacija->dateEnd;
        $trajanje = (strtotime($dateEnd)-strtotime($dateStart))/24/60/60;
        $test=strtotime($dateStart) - strtotime(date("Y-m-d"));

        $trajanjeDoKraja=(strtotime($dateEnd)-strtotime(date("Y-m-d")))/24/60/60;
        $test2=strtotime($dateEnd) - strtotime(date("Y-m-d"));
        
        if($brojDana>0)
        {
            $id_auto=$rezervacija->car_id;
            $model=$rezervacija->model;
            $newDateStart=date('Y-m-d', strtotime($dateEnd." + 1 days"));
            $newDateEnd=date('Y-m-d', strtotime($dateEnd." + ".$brojDana." days"));
            if(PomFunkResource::freeCar($id_auto,$newDateStart,$newDateEnd) and ReservationResource::checkExparationReg($id_auto,$newDateEnd))
            {
                $newCost=PomFunkResource::totalCost($model,$dateStart,$newDateEnd);
                Reservationresource::updateReservation($newDateEnd,$newCost,$id);
                $info=ReservationResource::returnInformation($id);
                Reservationresource::sendMeil($info,'extend');
                return ("Rezervacija $id je produzena do $newDateEnd. Nova cena je $newCost.");
            }
            else
            {
                return ("Rezervacija se ne moze produziti!");
            }
        }
        //jos uvek nije pocela i skracenje je manje od trajanja ili rezervacij je u toku, ali je skracivanje manje od ukupnog preostalog vremena
        elseif(($test>0 and $trajanje>abs($brojDana)) or ($test<=0 and $test2>0 and $trajanjeDoKraja>abs($brojDana)))
        {
            $id_auto=$rezervacija->car_id;
            $model=$rezervacija->model;
            $newDateEnd=date('Y-m-d', strtotime($dateEnd." - ".abs($brojDana)." days"));
            $newCost=PomFunkResource::totalCost($model,$dateStart,$newDateEnd);
            ReservationResource::updateReservation($newDateEnd,$newCost,$id);
            $info=ReservationResource::returnInformation($id);
            ReservationResource::sendMeil($info,'shortend');
            return ("Rezervacija $id je skracena do $newDateEnd. Nova cena je $newCost.");
        }
        
        else
        {
            return ("Broj dana nije pravilan!");
        }
    }

    //from reservation meni
    public function cancelReservation($id)
    {
        $info=ReservationResource::returnInformation($id);
        ReservationResource::cancelFutureReservation($id);
        if($info->opis=='SERVIS')
        {
            //ako ukidamo servis, izbaci auto iz spiska onih koji su na servisu
            $auto=AutomobiliModel::where('Broj_sasije',$info->car_id)->firstOrFail();
            $auto->Servis=0;
            $auto->save();
        }
        else
        {
          ReservationResource::sendMeil($info,'cancel');  
        }
        
        // return redirect('/rezervacijeInfo/all');
        return back();
    }
}
