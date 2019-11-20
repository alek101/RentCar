<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\TipoviAutomobilaModel;
use App\AutomobiliModel;
use App\HTTP\Resources\PomFunkResource;

class ReservationController extends Controller
{
    //Funkcije koje vracaju stranice ili rade sa JSON-om

    //Pravi stranicu sa svim rezervacijama
    public function allReservations($num=50)
    {
        $niz=$this->getAllReservationsDESC($num);  
        return view('rezervacijeInfo.sve',['niz'=>$niz]);
    }

    //forma iz rezervacija
    public function allReservationForm(Request $request)
    {
        if($request->order=="DESC")
        {
            if(isset($request->num))
            {
                $niz=$this->getAllReservationsDESC($request->num);  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }
            
            if(isset($request->dateStart) && isset($request->dateEnd))
            {
                $niz=$this->getReservationsDateDESC($request->dateStart,$request->dateEnd);  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }

            if(isset($request->dateStart) && !isset($request->dateEnd))
            {
                $dateEnd=date('Y-m-d', strtotime($request->dateStart." + 365 days"));
                $niz=$this->getReservationsDateDESC($request->dateStart,$dateEnd);  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }
            
            if(!isset($request->dateStart) && isset($request->dateEnd))
            {
                $dateStart=date('Y-m-d', strtotime($request->dateEnd." - 365 days"));
                $niz=$this->getReservationsDateDESC($dateStart,$request->dateEnd);  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }
        }

        if($request->order=="ASC")
        {
            if(isset($request->num))
            {
                $niz=$this->getAllReservationsASC($request->num);  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }
            
            if(isset($request->dateStart) && isset($request->dateEnd))
            {
                $niz=$this->getReservationsDateASC($request->dateStart,$request->dateEnd);  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }

            if(isset($request->dateStart) && !isset($request->dateEnd))
            {
                $dateEnd=date('Y-m-d', strtotime($request->dateStart." + 365 days"));
                $niz=$this->getReservationsDateASC($request->dateStart,$dateEnd);  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }
            
            if(!isset($request->dateStart) && isset($request->dateEnd))
            {
                $dateStart=date('Y-m-d', strtotime($request->dateEnd." - 365 days"));
                $niz=$this->getReservationsDateASC($dateStart,$request->dateEnd);  
                return view('rezervacijeInfo.sve',['niz'=>$niz]);
            }
        }
            
        return $this->allReservations();
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
                $info=$this->returnInformation($idRezervacije);
                $this->sendMeil($info[0],'new');
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

    //
    public function getExtendForm($id)
    {
        return view('rezervacijeInfo.extendForm',['id'=>$id]);
    }

    //pravi glavnu stranicu za rezervacije
    public function zakaziPrikaz1()
    {
        return view('zakazi.prikaz1');
    }

    //Pomocne funkcije I reda

    

    //from reservation meni
    public function cancelReservation($id)
    {
        $info=$this->returnInformation($id);
        $this->cancelFutureReservation($id);
        if($info[0]->opis=='SERVIS')
        {
            //ako ukidamo servis, izbaci auto iz spiska onih koji su na servisu
            $auto=AutomobiliModel::where('Broj_sasije',$info->car_id)->firstOrFail();
            $auto->Servis=0;
            $auto->save();
        }
        else
        {
          $this->sendMeil($info[0],'cancel');  
        }
        
        return redirect('/rezervacijeInfo/all');
    }

    //from car meni
    public function cancelReservationA($id)
    {
        $info=$this->returnInformation($id);
        $this->cancelFutureReservation($id);
        if($info[0]->opis=='SERVIS')
        {
            //ako ukidamo servis, izbaci auto iz spiska onih koji su na servisu
            $auto=AutomobiliModel::where('Broj_sasije',$info->car_id)->firstOrFail();
            $auto->Servis=0;
            $auto->save();
        }
        else
        {
          $this->sendMeil($info[0],'cancel');  
        }
        return redirect('/auto/info/'.$info[0]->car_id);
    }

    //produzenje rezervacije
    public function extendReservation(Request $request)
    {
        $id=$request->id;
        $brojDana=$request->brojDana;
        $rezervacija=$this->returnInformation($id);
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
            if(PomFunkResource::freeCar($id_auto,$newDateStart,$newDateEnd) and $this->checkExparationReg($id_auto,$newDateEnd))
            {
                $newCost=PomFunkResource::totalCost($model,$dateStart,$newDateEnd);
                $this->updateReservation($newDateEnd,$newCost,$id);
                $info=$this->returnInformation($id);
                $this->sendMeil($info,'extend');
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
            $this->updateReservation($newDateEnd,$newCost,$id);
            $info=$this->returnInformation($id);
            $this->sendMeil($info,'shortend');
            return ("Rezervacija $id je skracena do $newDateEnd. Nova cena je $newCost.");
        }
        
        else
        {
            return ("Broj dana nije pravilan!");
        }
            
    }

    //svi automobili koji smeju da se rezervisu
    public function aveilibleCars($dateStart,$dateEnd)
    {
        $automobili=PomFunkResource::getAllCars();
        $rezultat=[];
        foreach($automobili as $auto)
        {
            if(PomFunkResource::freeCar($auto->sasija,$dateStart,$dateEnd) and $this->checkExparationReg($auto->sasija,$dateEnd))
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


    //Pomocne funkcije II reda

    //spisak rezervacija u vremenskom okviru
    public function getReservationsDateDESC($dateStart,$dateEnd)
    {
        return DB::select(
            "SELECT
            R.`ID_rezervacije` as 'id',
            R.`Ime_prezime_kupca` as 'ime',
            R.`Email` as 'meil',
            R.`Broj_telefona` as 'telefon',
            A.`Broj_registarskih_tablica` as 'tablice',
            A.`Model` as 'model',
            R.`Datum_pocetka` as 'start',
            R.`Datum_zavrsetka` as 'finish',
            R.`Cena` as 'cena',
            R.`Napomena` as 'opis'
        FROM
            `rezervacija` as R
        join `automobili` as A on R.ID_vozila=A.Broj_sasije
        where ((R.`Datum_pocetka` >=? and R.`Datum_pocetka` <=?) and (R.`Datum_zavrsetka` >=? and R.`Datum_zavrsetka` <=?))
        order by `Datum_pocetka` DESC
        ",[$dateStart,$dateEnd,$dateStart,$dateEnd]);   
    }

    //
    public function getAllReservationsDESC($num)
    {
        return DB::select(
            "SELECT
            R.`ID_rezervacije` as 'id',
            R.`Ime_prezime_kupca` as 'ime',
            R.`Email` as 'meil',
            R.`Broj_telefona` as 'telefon',
            A.`Broj_registarskih_tablica` as 'tablice',
            A.`Model` as 'model',
            R.`Datum_pocetka` as 'start',
            R.`Datum_zavrsetka` as 'finish',
            R.`Cena` as 'cena',
            R.`Napomena` as 'opis'
        FROM
            `rezervacija` as R
        join `automobili` as A on R.ID_vozila=A.Broj_sasije
        order by `Datum_pocetka` DESC
        LIMIT ?",[$num]);   
    }

    //spisak rezervacija u vremenskom okviru
    public function getReservationsDateASC($dateStart,$dateEnd)
    {
        return DB::select(
            "SELECT
            R.`ID_rezervacije` as 'id',
            R.`Ime_prezime_kupca` as 'ime',
            R.`Email` as 'meil',
            R.`Broj_telefona` as 'telefon',
            A.`Broj_registarskih_tablica` as 'tablice',
            A.`Model` as 'model',
            R.`Datum_pocetka` as 'start',
            R.`Datum_zavrsetka` as 'finish',
            R.`Cena` as 'cena',
            R.`Napomena` as 'opis'
        FROM
            `rezervacija` as R
        join `automobili` as A on R.ID_vozila=A.Broj_sasije
        where ((R.`Datum_pocetka` >=? and R.`Datum_pocetka` <=?) and (R.`Datum_zavrsetka` >=? and R.`Datum_zavrsetka` <=?))
        order by `Datum_pocetka` ASC
        ",[$dateStart,$dateEnd,$dateStart,$dateEnd]);   
    }

    //
    public function getAllReservationsASC($num)
    {
        return DB::select(
            "SELECT
            R.`ID_rezervacije` as 'id',
            R.`Ime_prezime_kupca` as 'ime',
            R.`Email` as 'meil',
            R.`Broj_telefona` as 'telefon',
            A.`Broj_registarskih_tablica` as 'tablice',
            A.`Model` as 'model',
            R.`Datum_pocetka` as 'start',
            R.`Datum_zavrsetka` as 'finish',
            R.`Cena` as 'cena',
            R.`Napomena` as 'opis'
        FROM
            `rezervacija` as R
        join `automobili` as A on R.ID_vozila=A.Broj_sasije
        order by `Datum_pocetka` ASC
        LIMIT ?",[$num]);   
    }

    //pomocna funkcija koja proverava da li auto sme da se rezervise
    public function checkExparationReg($id,$dateEnd,$crit_time=3)
    {
        $razlika=DB::select(
            "SELECT
            DATEDIFF(`Datum_vazenja_registracije`,?) as razlika
        FROM
            `automobili`
        WHERE
            `Broj_sasije`=?",[$dateEnd,$id])[0];

        if($razlika->razlika>=$crit_time)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //informacije o rezervaciji
    public function returnInformation($idRezervacije)
    {
        $pom=DB::select(
        "SELECT
        `ID_rezervacije` as 'id_rez',
        `Ime_prezime_kupca` as 'ime',
        `Email` as 'email',
        `Broj_telefona` as 'telefon',
        `Datum_pocetka` as 'dateStart',
        `Datum_zavrsetka` as 'dateEnd',
        `Broj_registarskih_tablica` as 'tablice',
        `Model` as 'model',
        `Cena` as 'cena',
        A.Broj_sasije as 'car_id',
        `Napomena` as 'opis'
        FROM
            `rezervacija` AS R
        JOIN `automobili` AS A
        ON
            R.ID_vozila = A.Broj_sasije
        WHERE
            `ID_rezervacije` = ?",[$idRezervacije]);
            return $pom[0];
    }

    //otkazivanje rezervacije u bazi
    public function cancelFutureReservation($id)
    {
        DB::delete("DELETE
        FROM
            `rezervacija`
        WHERE
            `ID_rezervacije`=? and CURRENT_DATE()<=`Datum_pocetka`+3",[$id]);
    }

    //azuriranje rezervacija
    public function updateReservation($newDateEnd,$newCost,$id)
    {
        DB::update(
            "
            UPDATE `rezervacija` 
            SET `Datum_zavrsetka` = ?, 
            `Cena`=? 
            WHERE `rezervacija`.`ID_rezervacije` = ?
            ",[$newDateEnd,$newCost,$id]
        );
    }

    //Funkcija koja salje mejl kupcu-trenutno je iskljucena da ne bi bagovala
    function sendMeil($info,$tip='new')
        {

        //     if($tip=='new')
        //     {
        //         $naslov="Uspesna rezervacija";
        //         $poruka="Uspesno ste rezervisali auto $info->model sa registarskim tablicama $info->tablice na ime: $info->ime
        //         , u vremenskom periodu od $info->dateStart do $info->dateEnd. Broj Vase rezervacije je $info->id_rez. Ukupna cena je $info->cena.";
        //         $poruka=wordwrap($poruka,70,"\n");
        //         mail($info->email,$naslov,$poruka);
        //     }

        //     if($tip=='extend')
        //     {
        //         $naslov="Uspesno produznje";
        //         $poruka="Uspesno ste produzili rezervaciju automobila $info->model sa registarskim tablicama $info->tablice na ime: $info->ime
        //         , u novom vremenskom periodu od $info->dateStart do $info->dateEnd. Broj Vase rezervacije je $info->id_rez. Nova cena je $info->cena.";
        //         $poruka=wordwrap($poruka,70,"\n");
        //         mail($info->email,$naslov,$poruka);
        //     }

        //     if($tip=='shortend')
        //     {
        //         $naslov="Uspesno skracenje";
        //         $poruka="Uspesno ste skratili rezervaciju automobila $info->model sa registarskim tablicama $info->tablice na ime: $info->ime
        //         , u novom vremenskom periodu od $info->dateStart do $info->dateEnd. Broj Vase rezervacije je $info->id_rez. Nova cena je $info->cena.";
        //         $poruka=wordwrap($poruka,70,"\n");
        //         mail($info->email,$naslov,$poruka);
        //     }

        //     if($tip=='cancel')
        //     {
        //         $naslov="Rezervaicja je ukinuta";
        //         $poruka="Rrezervaciju automobila $info->model sa registarskim tablicama $info->tablice na ime: $info->ime
        //         , u novom vremenskom periodu od $info->dateStart do $info->dateEnd je ukinuta. Broj Vase rezervacije je $info->id_rez.";
        //         $poruka=wordwrap($poruka,70,"\n");
        //         mail($info->email,$naslov,$poruka);
        //     }
        }
}
