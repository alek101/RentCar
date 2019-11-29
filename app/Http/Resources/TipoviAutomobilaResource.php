<?php

namespace App\Http\Resources;
use App\TipoviAutomobilaModel;
use App\CenovnikModel;
use App\AutomobiliModel;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TipoviAutomobilaResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    //vraca podatke za spisak modela za koji postoji barem jedan aktivan automobil
    public static function modeliAktivni()
    {
        $models=[];
        $cars=AutomobiliModel::where('Aktivan',1)->get();
        $modelsBook=TipoviAutomobilaModel::all();
        forEach($modelsBook as $singleModel)
        {
            //proveravamo da li od datok modela singleModel, postojai barem jedan aktivan auto
            $check=false;
            forEach($cars as $car)
            {
                if($singleModel->Model===$car->Model)
                {
                    $check=true;
                    break;
                }
            }
            if($check)
            {
                array_push($models,$singleModel);
            }
        }
        
        return $models;
    }
}
