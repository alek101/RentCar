@extends('mainPage')
@section('Page')

@php
    // echo $id;
    // echo "SERVIS 2";
    
@endphp

<form method="POST" action="/kriticni/posalji2">
    @csrf
    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" id='token'> --}}
    Broj Sasije <input type="text" name='id' value="<?=$id?>" id="id">
    Pocetak <input type="date" name="dateStart" id="start" value="{{ $dateStart }}">
    Zavrsetak <input type="date" name="dateEnd" id="end" value="{{$dateEnd}}">
    <input type="submit" value="Posalji" id="dugme">

</form>

<a href="https://www.animatedimages.org/cat-cars-67.htm"><img src="https://www.animatedimages.org/data/media/67/animated-car-image-0161.gif" border="0" alt="animated-car-image-0161" /></a>

@endsection