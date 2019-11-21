<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoviAutomobilaModel;
use App\HTTP\Resources\PomFunkResource;
use App\HTTP\Resources\ReservationResource;

class BookingController extends Controller
{
    //pravi glavnu stranicu za rezervacije
    public function zakaziPrikaz1()
    {
        return view('zakazi.prikaz1');
    }
    
    //funkcija koja pravi json za fron end stranu
    public function makeJSONforBooking(Request $request)
    {
        $request->validate([
            'dateStart'=>'required|date',
            'dateEnd'=>'required|date',
        ]);

        $dateStart=$request->dateStart;
        $dateEnd=$request->dateEnd;

        $diff = strtotime($dateEnd) - strtotime($dateStart);
        $json=[];

        if($diff>0)
        {
            $cars=ReservationResource::aveilibleCars($dateStart,$dateEnd);
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
        $request->validate([
            'dateStart'=>'required|date',
            'dateEnd'=>'required|date',
            'model'=>'required',
            'ime'=>'required',
            'telefon'=>'required',
            'email'=>'required',
        ]);

        $dateStart=$request->dateStart;
        $dateEnd=$request->dateEnd;
        $model=$request->model;
        $ime=$request->ime;
        $telefon=$request->telefon;
        $email=$request->email;
        $comment=$request->comment ?? 'no comment';

        //SERVIS je rezervisana rec
        if($comment==="SERVIS")
        {
            $comment.="_korisnik";
        }

        $comment=substr($comment,0,255);
        $telefon=str_replace("+",99,$telefon);

        $cena=PomFunkResource::totalCost($model,$dateStart,$dateEnd);
        
        if($cena>0 )
        {
            $cars=ReservationResource::aveilibleCars($dateStart,$dateEnd);
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
}
