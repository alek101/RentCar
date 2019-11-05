{{-- @php
    // var_dump($info);

@endphp --}}

@extends('mainPage')
@section('Page')

<h1>Uspesna Rezervacija</h1>

<div class='info_rez'>Rezervisali ste model: {{ $info[0]->model }} sa registarskim tablicama {{ $info[0]->tablice }} u periodu od {{ $info[0]->dateStart }} - {{ $info[0]->dateEnd }}
 na ime {{ $info[0]->ime }}. Cena je {{ $info[0]->cena }}. Šifra rezervacje je {{ $info[0]->id_rez }}.</div>

@endsection