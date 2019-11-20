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
    //Funkcije koje vracaju stranice ili rade sa JSON-om

    //pravi glavnu stranicu za rezervacije
    public function zakaziPrikaz1()
    {
        return view('zakazi.prikaz1');
    }
    
    //funkcija koja pravi json za fron end stranu
    public function makeJSONforBooking(Request $request)
    {
        $dateStart=$request->dateStart;
        $dateEnd=$request->dateEnd;

        $diff = strtotime($dateEnd) - strtotime($dateStart);
        $json=[];

        if($diff>0)
        {
            $cars=$this->aveilibleCars($dateStart,$dateEnd);
            $models=array_keys($cars);
            $readyModels=[];
            $cene=[];

            foreach($models as $model)
            {
                $readyModels[$model]=TipoviAutomobilaModel::where('Model',$model)->first();
                $cene[$model]=PomFunkResource::totalCost($model,$dateStart,$dateEnd);
            }
            
            // $json['cars']=$cars;
            $json['unique_models']=$models;
            $json['cene']=$cene;
            $json['podaci']=$readyModels;
        }
        else
        {
            $json['unique_models']=[];
            $json['cene']=[];
            $json['podaci']=[];
        }

        $paket=json_encode($json);
        
        return $paket;
    }

    //booking
    public function makeBookingWithFetch(Request $request)
    {
        $dateStart=$request->dateStart;
        $dateEnd=$request->dateEnd;
        $model=$request->model;
        $ime=$request->ime;
        $telefon=$request->telefon;
        $email=$request->email;
        $comment=$request->comment;

        //SERVIS je rezervisana rec
        if($comment==="SERVIS")
        {
            $comment.="_korisnik";
        }

        $cena=PomFunkResource::totalCost($model,$dateStart,$dateEnd);
        
        if($cena>0 )
        {
            $cars=$this->aveilibleCars($dateStart,$dateEnd);
            $broj=rand(0,count($cars[$model])-1);
            $izabranAutoID=$cars[$model][$broj];
            if(PomFunkResource::freeCar($izabranAutoID,$dateStart,$dateEnd))
            {
                $idRezervacije=PomFunkResource::insertReservation($izabranAutoID,$ime,$email,$telefon,$dateStart,$dateEnd,$comment,$cena);
            }
            if(isset($idRezervacije) and $idRezervacije > 0)
            {
                $info=ReservationResource::returnInformation($idRezervacije);
                ReservationResource::sendMeil($info,'new');
                return json_encode($info); 
            }
            else
            {
                return json_encode("Nije proslo!");
            }
             
        }
        else
        {
            return json_encode("Los period!");
        }
    }

    //Pravi stranicu sa svim rezervacijama
    public function allReservations($num=50)
    {
        $niz=ReservationResource::getAllReservationsDESC($num);  
        return view('rezervacijeInfo.sve',['niz'=>$niz]);
    }

    //forma iz rezervacija
    public function allReservationForm(Request $request)
    {
        if($request->order=="DESC")
        {
            if(isset($request->num))
            {
                $niz=ReservationResource::getAllReservationsDESC($request->num);  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }
            
            if(isset($request->dateStart) && isset($request->dateEnd))
            {
                $niz=ReservationResource::getReservationsDateDESC($request->dateStart,$request->dateEnd);  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }

            if(isset($request->dateStart) && !isset($request->dateEnd))
            {
                $dateEnd=date('Y-m-d', strtotime($request->dateStart." + 365 days"));
                $niz=ReservationResource::getReservationsDateDESC($request->dateStart,$dateEnd);  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }
            
            if(!isset($request->dateStart) && isset($request->dateEnd))
            {
                $dateStart=date('Y-m-d', strtotime($request->dateEnd." - 365 days"));
                $niz=ReservationResource::getReservationsDateDESC($dateStart,$request->dateEnd);  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }
        }

        if($request->order=="ASC")
        {
            if(isset($request->num))
            {
                $niz=ReservationResource::getAllReservationsASC($request->num);  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }
            
            if(isset($request->dateStart) && isset($request->dateEnd))
            {
                $niz=ReservationResource::getReservationsDateASC($request->dateStart,$request->dateEnd);  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }

            if(isset($request->dateStart) && !isset($request->dateEnd))
            {
                $dateEnd=date('Y-m-d', strtotime($request->dateStart." + 365 days"));
                $niz=ReservationResource::getReservationsDateASC($request->dateStart,$dateEnd);  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }
            
            if(!isset($request->dateStart) && isset($request->dateEnd))
            {
                $dateStart=date('Y-m-d', strtotime($request->dateEnd." - 365 days"));
                $niz=ReservationResource::getReservationsDateASC($dateStart,$request->dateEnd);  
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

    //Pomocne funkcije I reda

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
        
        return redirect('/rezervacijeInfo/all');
    }

    //from car meni
    public function cancelReservationA($id)
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
        return redirect('/auto/info/'.$info->car_id);
    }

    //svi automobili koji smeju da se rezervisu
    public function aveilibleCars($dateStart,$dateEnd)
    {
        $automobili=PomFunkResource::getAllCars();
        $rezultat=[];
        foreach($automobili as $auto)
        {
            if(PomFunkResource::freeCar($auto->sasija,$dateStart,$dateEnd) and ReservationResource::checkExparationReg($auto->sasija,$dateEnd))
            {
                $model=$auto->model;
                if(!isset($rezultat[$model]))
                {
                    $rezultat[$model]=[$auto->sasija];
                }
                else
                {
                    array_push($rezultat[$model],$auto->sasija);
                }
            }
        }
        return $rezultat;
    }
}
