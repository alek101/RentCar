<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App;
use App\TipoviAutomobila;

class MainController extends Controller
{
    //Daje automobile koji moraju uskro da imaju servis
    public function kriticni()
    {
        $niz=DB::select("SELECT
        `Broj_sasije` as 'sasija',
        `Broj_saobracajne_dozvole` as 'saobracajna',
        `Broj_registarskih_tablica` as 'tablica',
        `Model` as 'model',
        `Godina_proizvodnje` as 'godiste',
        `Predjena_km` as 'kilometraza',
        `Datum_vazenja_registracije` as 'registracija',
        `Radjen_mali_servis_km` as 'mali_servis',
        `Radjen_veliki_servis_km` as 'veliki_servis',
        DATEDIFF(`Datum_vazenja_registracije`,CURRENT_DATE()) as 'isticanje_registracije',
        `Predjena_km`-`Radjen_mali_servis_km` as 'predjeno_km_mali',
        `Predjena_km`-`Radjen_veliki_servis_km` as 'predjeno_km_veliki'
    FROM
        `automobili`
    WHERE
        `Servis`=0 and
         (DATEDIFF(`Datum_vazenja_registracije`,CURRENT_DATE())<=? OR
         `Predjena_km`-`Radjen_mali_servis_km`>=? OR
         `Predjena_km`-`Radjen_veliki_servis_km`>=?)",[30,10000,100000]);
        
        return view('kriticni.kriticni',['niz'=>$niz]);
    }

    //zakazivanej servisa
    public function zakaziServis($id)
    {
        return view('kriticni.zakaziServis',['id'=>$id]);
    }

    //trazenje pogodnog datuma za servis
    public function posalji1(Request $request )
    {
        $id=$request->id;
        $brojDana=$request->brojDana-1;
        if($brojDana>=0)
        {
        $dateStart=$this->findNextFreeDate($id,$brojDana);
        $dateEnd=$dateEnd=date('Y-m-d', strtotime($dateStart." + $brojDana days"));

        return view('kriticni.zakaziServis2',["id"=>$id,"dateStart"=>$dateStart,"dateEnd"=>$dateEnd]);
        }
        else
        {
            return $this->kriticni();
        }
    }

    //i konacno zakazivanje istog
    public function posalji2(Request $request )
    {
        $id=$request->id;
        $dateStart=$request->dateStart;
        $dateEnd=$request->dateEnd;

        $check=$this->freeCar($id,$dateStart,$dateEnd);
        
        if($check)
        {
        //transakcija 
        $this->changeCarServis($id);
        $this->insertReservation($id,'ADMIN','ADMIN','ADMIN',$dateStart,$dateEnd,'SERVIS',0);
        return $this->kriticni();
        //end transakcija
        }
        else
        {
            return view('kriticni.zakaziServis2',["id"=>$id,"dateStart"=>$dateStart,"dateEnd"=>$dateEnd]);
        }
        
    }

    //pomocna fun koja daje da li je auto slobodan tog datuma ili ne
    public function freeCar($id,$dateStart,$dateEnd)
    {
        $niz=DB::select(
            'SELECT
            A.Broj_sasije AS "id"
        FROM
            `automobili` AS A
        LEFT JOIN `rezervacija` AS R
        ON
            A.Broj_sasije = R.ID_vozila
        WHERE
            A.Broj_sasije=?
            and
            ((
                ? >= R.Datum_pocetka AND ? <= R.Datum_zavrsetka
            ) OR(
                ? >= R.Datum_pocetka AND ? <= R.Datum_zavrsetka
            ))',[$id,$dateStart,$dateStart,$dateEnd,$dateEnd]
        );

        if(count($niz)==0)
            {
                return true;
            }
            else
            {
                return false;
            };
    }

    //pomocna funkcija koja daje sledeci slobodan datum
    public function findNextFreeDate($id,$brojDana)
    {
        if($brojDana>=1)
        {
            $check=false;
            $brojDana=$brojDana-1;
            $trenutniDatum=date("Y-m-d");
            $dateStart=$trenutniDatum;
            $dateEnd=date('Y-m-d', strtotime($dateStart." + $brojDana days"));
            $brojac=0;
            while($check==false and $brojac<1000)
            {
                if($this->freeCar($id,$dateStart,$dateEnd))
                {
                    $check=true;
                }
                else
                {
                    $dateStart=date('Y-m-d', strtotime($dateStart." + 1 days"));
                    $dateEnd=date('Y-m-d', strtotime($dateEnd." + 1 days"));
                    $brojac++;
                }
            }
            return $dateStart;
        }
        
    }

    //Pravljenje rezervacije
    public function insertReservation($idVozila,$ime,$email,$telefon,$dateStart,$dateEnd,$comment,$cena)
    {
            //NEED TO ADD: check if registration is stile valid, limit future reservation for the next 14 days
            DB::insert(
            "INSERT INTO `rezervacija`(`ID_vozila`, `Ime_prezime_kupca`, `Email`, `Broj_telefona`, `Datum_pocetka`, `Datum_zavrsetka`, `Cena`, `Aktivna`, `Napomena`) 
            VALUES (?,?,?,?,?,?,?,1,?)",[$idVozila,$ime,$email,$telefon,$dateStart,$dateEnd,$cena,$comment]);
            return DB::getPdo()->lastInsertId();
    }

    //
    function getServis($id)
        {
            return DB::select("SELECT
            `Servis`
        FROM
            `automobili`
        WHERE
            `Broj_sasije`=?",[$id]);
        }

    //
    function setServis($id,$val)
    {
        DB::update("UPDATE
        `automobili`
    SET
        `Servis` = ?
    WHERE
        `Broj_sasije`=?",[$val,$id]);
    }

    //Menja stanje servisa, 0 nije na servisu, 1 da jeste na servisu
    function changeCarServis($id)
    {
        $val=$this->getServis($id)[0]->Servis;

        if($val==0)
        {
            $this->setServis($id,1);
        }
        else
        {
            $this->setServis($id,0);
        }
    }
    
    //Servis
    //automobili na servisu
    public function servis()
    {
        $niz=DB::select("SELECT
        `Broj_sasije` as 'sasija',
        `Broj_saobracajne_dozvole` as 'saobracajna',
        `Broj_registarskih_tablica` as 'tablica',
        `Model` as 'model',
        `Godina_proizvodnje` as 'godiste',
        `Predjena_km` as 'kilometraza',
        `Datum_vazenja_registracije` as 'registracija',
        `Radjen_mali_servis_km` as 'mali_servis',
        `Radjen_veliki_servis_km` as 'veliki_servis',
        DATEDIFF(`Datum_vazenja_registracije`,CURRENT_DATE()) as 'isticanje_registracije',
        `Predjena_km`-`Radjen_mali_servis_km` as 'predjeno_km_mali',
        `Predjena_km`-`Radjen_veliki_servis_km` as 'predjeno_km_veliki'
    FROM
        `automobili`
    WHERE
        `Servis`=1 ",[]);
        
        return view('servis.servis',['niz'=>$niz]);
    }

    //
    public function servisCar($id)
    {
        return view('servis.uradi',['id'=>$id]);
    }

    //
    public function endServis(Request $request)
    {
        $id=$request->id;
        $tip=$request->tip;
        $datum=$request->datum;
        $opis=$request->opis;
        $registracija=$request->registracija;
        $this->madeServis($id,$tip,$datum,$opis,$registracija);
        return $this->servis();
    }

    //
    function madeServis($id,$tip,$datum,$opis,$registracija)
        {
            $km=$this->getKM($id)[0]->km;

            if($tip=='mali')
            {
                $this->insertServis($id,$datum,$km,'mali',$opis);
                $this->setMaliServisKM($id,$km);
                $this->changeCarServis($id);
            }
            if($tip=='veliki')
            {
                $this->insertServis($id,$datum,$km,'mali',$opis);
                $this->setMaliServisKM($id,$km);
                $this->setVelikiServisKM($id,$km);
                $this->changeCarServis($id);
            }
            if ($tip=='cancel')
            {
                $this->changeCarServis($id);
            }
            if($tip=='registracija')
            {
                $this->setRegistracija($id,$registracija);
                $this->changeCarServis($id);
            }
        }

    //
    function getKM($id)
    {
        return DB::select("SELECT
        `Predjena_km` as 'km'
    FROM
        `automobili`
    WHERE
        `Broj_sasije`=?",[$id]);
    }
    
    //function
    public function setKM($id,$km)
    {
        DB::update("
            UPDATE `automobili`
            SET `Predjena_km`=?
            where `Broj_sasije`=?
            ",[$km,$id]);   
    }

    //
    public function insertServis($id,$datum,$km,$tip,$opis)
    {
        DB::insert("INSERT INTO `servisna_knjizica`(`ID_automobila`, `Datum`, `Kilometraza`, `Tip_servisa`, `Opis`) 
            VALUES (?,?,?,?,?)",[$id,$datum,$km,$tip,$opis]);
    }

    //
    public function setMaliServisKm($id,$km)
    {
        DB::update("
        UPDATE `automobili`
        SET `Radjen_mali_servis_km`=?
        where `Broj_sasije`=?
        ",[$km,$id]);
    }

    //
    public function setVelikiServisKM($id,$km)
    {
        DB::update("
        UPDATE `automobili`
        SET `Radjen_veliki_servis_km`=?
        where `Broj_sasije`=?
        ",[$km,$id]);
    }

    //
    public function setRegistracija($id,$newDate)
        {
            DB::update(
            "
            UPDATE `automobili`
            SET `Datum_vazenja_registracije`=?
            where `Broj_sasije`=?
            ",[$newDate,$id]);
        }
    
    //vraca broj sasije u odnosu na broj tablica
    public function getID($tablica)
    {
        return DB::select(
            "
            SELECT
            `Broj_sasije`as 'id'
            FROM
                `automobili`
            WHERE
                `Broj_registarskih_tablica`=?
            ",[$tablica]
        )[0]->id;
    }

    //
    public function prijem()
    {
        return view('prijem.prijem');
    }

    //
    public function izmeniKM(Request $request)
    {
        $id=$request->id;
        $tablica=$request->tablica;
        $km=$request->km;

        if(isset($id) and $km>0)
        {
            $this->addKM($id,$km);
            return $this->autoInfo($id);
        }
        if(isset($tablica) and $km>0)
        {
            $id=$this->getID($tablica);
            $this->addKM($id,$km);
            return $this->prijem();
        }

        
    }


    //
    public function addKM($id,$km)
    {
        $predjena=$this->getKM($id)[0]->km;
        $nova=$predjena+$km;
        $this->setKM($id,$nova);
    }

    //automobili
    //
    public function getAllCars()
    {
        return DB::select("SELECT
        `Broj_sasije` as 'sasija',
        `Broj_saobracajne_dozvole` as 'saobracajna',
        `Broj_registarskih_tablica` as 'tablica',
        `Model` as 'model',
        `Godina_proizvodnje` as 'godiste',
        `Predjena_km` as 'kilometraza',
        `Datum_vazenja_registracije` as 'registracija',
        `Radjen_mali_servis_km` as 'mali_servis',
        `Radjen_veliki_servis_km` as 'veliki_servis',
        DATEDIFF(`Datum_vazenja_registracije`,CURRENT_DATE()) as 'isticanje_registracije',
        `Predjena_km`-`Radjen_mali_servis_km` as 'predjeno_km_mali',
        `Predjena_km`-`Radjen_veliki_servis_km` as 'predjeno_km_veliki'
    FROM
        `automobili`
    ",[]);
    }

    //
    public function auto()
    {
        $niz=$this->getAllCars();
        return view('auto.auto',['niz'=>$niz]);
    }

    //
    function getOneCar($id)
    {
        return DB::select("SELECT
        `Broj_sasije` as 'sasija',
        `Broj_saobracajne_dozvole` as 'saobracajna',
        `Broj_registarskih_tablica` as 'tablica',
        `Model` as 'model',
        `Godina_proizvodnje` as 'godiste',
        `Predjena_km` as 'kilometraza',
        `Datum_vazenja_registracije` as 'registracija',
        `Radjen_mali_servis_km` as 'mali_servis',
        `Radjen_veliki_servis_km` as 'veliki_servis',
        DATEDIFF(`Datum_vazenja_registracije`,CURRENT_DATE()) as 'isticanje_registracije',
        `Predjena_km`-`Radjen_mali_servis_km` as 'predjeno_km_mali',
        `Predjena_km`-`Radjen_veliki_servis_km` as 'predjeno_km_veliki'
    FROM
        `automobili`
    Where
        `Broj_sasije`=?
    ",[$id]);
    }


    //informacije o jednom autu
    public function autoInfo($id)
    {
        $auto=$this->getOneCar($id);
        $knjizica=$this->servisnaKnjizica($id);
        $niz=$this->getFutureReservationCar($id);
        return view('auto.info',['auto'=>$auto[0],'knjizica'=>$knjizica, 'niz'=>$niz]);
    }

    //
    public function servisnaKnjizica($id)
    {
        return DB::select(
            "SELECT
            `Datum` as 'datum',
            `Kilometraza` as 'km',
            `Tip_servisa` as 'tip',
            `Opis` as 'opis'
            
        FROM
            `servisna_knjizica`
        WHERE
            `ID_automobila`=?",[$id]
        );
    }

    //REZERVACIJE

    //
    public function aveilibleCars($dateStart,$dateEnd)
    {
        $automobili=$this->getAllCars();
        $rezultat=[];
        foreach($automobili as $auto)
        {
            if($this->freeCar($auto->sasija,$dateStart,$dateEnd))
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

    //
    public function aveilibleModels($dateStart,$dateEnd)
    {
        return array_keys($this->aveilibleCars($dateStart,$dateEnd));
    }

    //
    public function rezervacija1()
    {
        return view('rezervacija.rezervacija1');
    }

    public function rezervacija2(Request $request)
    {
        $dateStart=$request->dateStart;
        $dateEnd=$request->dateEnd;

        $cars=$this->aveilibleCars($dateStart,$dateEnd);
        $models=array_keys($cars);
        $cene=[];

        foreach($models as $model)
        {
            $cene[$model]=$this->totalCost($model,$dateStart,$dateEnd);
        }

        //preko forme
        // return view('rezervacija.rezervacija2',['cars'=>$cars,'models'=>$models, 'dateStart'=>$dateStart, 'dateEnd'=>$dateEnd, 'cene'=>$cene]);
        //preko fetcha
        return view('rezervacija.rezervacija4',['cars'=>$cars,'models'=>$models, 'dateStart'=>$dateStart, 'dateEnd'=>$dateEnd, 'cene'=>$cene]); 
        //preko ajax-a i jQuerija
        // return view('rezervacija.rezervacija3',['cars'=>$cars,'models'=>$models, 'dateStart'=>$dateStart, 'dateEnd'=>$dateEnd, 'cene'=>$cene]);
        //preko axiosa
        // return view('rezervacija.rezervacija5',['cars'=>$cars,'models'=>$models, 'dateStart'=>$dateStart, 'dateEnd'=>$dateEnd, 'cene'=>$cene]);
    }

    //preko forme-izbaceno
    public function rezervacija3(Request $request)
    {
        $dateStart=$request->dateStart;
        $dateEnd=$request->dateEnd;
        $model=$request->model;
        $ime=$request->ime;
        $telefon=$request->telefon;
        $email=$request->email;
        $comment=$request->comment;

        $cars=$this->aveilibleCars($dateStart,$dateEnd);
        $broj=rand(0,count($cars[$model])-1);
        $izabranAutoID=$cars[$model][$broj];
        $cena=$this->totalCost($model,$dateStart,$dateEnd);
        $idRezervacije=$this->insertReservation($izabranAutoID,$ime,$email,$telefon,$dateStart,$dateEnd,$comment,$cena);
        $info=$this->returnInformation($idRezervacije);
        // $this->posaljiMejl($izabranAutoID,$model,$ime,$email,$dateStart,$dateEnd,$info,$cena);
        return view('rezervacija.info',['info'=>$info]);
    }

    //preko ajax-a ili fetch-a
    public function rezervacija4(Request $request)
    {
        $dateStart=$request->dateStart;
        $dateEnd=$request->dateEnd;
        $model=$request->model;
        $ime=$request->ime;
        $telefon=$request->telefon;
        $email=$request->email;
        $comment=$request->comment;

        
        $cena=$this->totalCost($model,$dateStart,$dateEnd);
        
        if($cena>0 )
        {
            $cars=$this->aveilibleCars($dateStart,$dateEnd);
            $broj=rand(0,count($cars[$model])-1);
            $izabranAutoID=$cars[$model][$broj];
            if($this->freeCar($izabranAutoID,$dateStart,$dateEnd))
            {
                $idRezervacije=$this->insertReservation($izabranAutoID,$ime,$email,$telefon,$dateStart,$dateEnd,$comment,$cena);
            }
            if(isset($idRezervacije) and $idRezervacije > 0)
            {
                $info=$this->returnInformation($idRezervacije);
                // $this->posaljiMejl($izabranAutoID,$model,$ime,$email,$dateStart,$dateEnd,$info,$cena);
                return json_encode($info[0]); 
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
    public function totalCost($model,$dateStart,$dateEnd)
    {
        $niz=DB::select("
        SELECT `cena_po_danu` AS 'cena', DATEDIFF(?, ?) as 'razlika' 
        FROM `cenovnik` WHERE 
        `Model` = ? AND `Max_broj_dana` >= DATEDIFF(?, ?)",[$dateEnd,$dateStart,$model,$dateEnd,$dateStart]);

        $max=0;
        foreach($niz as $clan)
        {
            if($clan->cena>$max)
            {
                $max=$clan->cena;
            }
        }
        return $niz[0]->razlika*$max;
    }

    //
    public function returnInformation($idRezervacije)
    {
        return DB::select(
        "SELECT
        `ID_rezervacije` as 'id_rez',
        `Ime_prezime_kupca` as 'ime',
        `Email` as 'email',
        `Broj_telefona` as 'telefon',
        `Datum_pocetka` as 'dateStart',
        `Datum_zavrsetka` as 'dateEnd',
        `Broj_registarskih_tablica` as 'tablice',
        `Model` as 'model',
        `Cena` as 'cena'
        FROM
            `rezervacija` AS R
        JOIN `automobili` AS A
        ON
            R.ID_vozila = A.Broj_sasije
        WHERE
            `ID_rezervacije` = ?",[$idRezervacije]);
    }

    //INFO rezervacije

    //
    public function futureReservations()
    {
        return DB::select("SELECT
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
        where CURRENT_DATE()<=R.`Datum_pocetka`
        order by `Datum_pocetka` ASC",[]);   
    }

    //
    public function rezervacijeInfo()
    {
        $niz=$this->futureReservations();  
        return view('rezervacijeInfo.buduce',['niz'=>$niz]);
    }

    //
    public function cancelFutureReservation($id)
    {
        DB::delete("DELETE
        FROM
            `rezervacija`
        WHERE
            `ID_rezervacije`=? and CURRENT_DATE()<=`Datum_pocetka`",[$id]);
    }

    //
    public function cancelReservation($id)
    {
        $info=$this->returnInformation($id);
        $this->cancelFutureReservation($id);
        // return $this->rezervacijeInfo();
        return redirect('/rezervacijeInfo');
    }

    //
    public function getAllReservations($num)
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

    //
    public function rezervacijeSve($num=50)
    {
        $niz=$this->getAllReservations($num);  
        return view('rezervacijeInfo.sve',['niz'=>$niz]);
    }

    //
    public function rezervacijeSveForm(Request $request)
    {
        if(isset($request->num))
        {
            $niz=$this->getAllReservations($request->num);  
            return view('rezervacijeInfo.sve',['niz'=>$niz]);
        }
        
        if(isset($request->dateStart) && isset($request->dateEnd))
        {
            $niz=$this->getReservationsDate($request->dateStart,$request->dateEnd);  
            return view('rezervacijeInfo.sve',['niz'=>$niz]);
        }

        if(isset($request->id))
        {
            $niz=$this->getReservationsID($request->id);
            return view('rezervacijeInfo.sve',['niz'=>$niz]);
        }
    }

    //
    public function getReservationsDate($dateStart,$dateEnd)
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
    public function getReservationsID($id)
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
        where R.`ID_rezervacije`=?
        ",[$id]);
    }

    //daj buduce rezervacije za odredjeni auto
    public function getFutureReservationCar($id)
    {
        return DB::select("SELECT
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
        where CURRENT_DATE()<=R.`Datum_pocetka` and A.Broj_sasije =?
        order by `Datum_pocetka` ASC",[$id]); 
    }

    //
    public function test1()
    {
        return view('test.form1');
    }
    public function test2()
    {
        $cars=$this->getAllCars();
        return json_encode($cars);
    }

    public function zakaziPrikaz1()
    {
        return view('zakazi.prikaz1');
    }

    public function podaci(Request $request)
    {
        $dateStart=$request->dateStart;
        $dateEnd=$request->dateEnd;
       
        // return json_encode(''.$dateStart.$dateEnd);

        $cars=$this->aveilibleCars($dateStart,$dateEnd);
        $models=array_keys($cars);
        $readyModels=[];
        $cene=[];

        foreach($models as $model)
        {
            $readyModels[$model]=TipoviAutomobila::where('Model',$model)->first();
            $cene[$model]=$this->totalCost($model,$dateStart,$dateEnd);
        }

        $json=[];
        // $json['cars']=$cars;
        $json['unique_models']=$models;
        $json['cene']=$cene;
        $json['podaci']=$readyModels;

        $paket=json_encode($json);
        
        return $paket;
        // return view('zakazi.prikaz2',['json'=>$json,'paket'=>$paket]); 
    }

}
