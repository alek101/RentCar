<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    //menja izgled datuma u naschki
    public static function dateLook($date)
    {
        $date=explode('-',$date);
        $date=array_reverse($date);
        $date=implode('.',$date).".";
        return $date;
    }
}
