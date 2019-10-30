@extends('mainPage')
@section('Page')

<form method="POST" action="/prijem/izmeniKM">
    @csrf
    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" id='token'> --}}
    {{-- Broj Sasije  --}}
    <input type="text" name='id' value="" id="id" hidden>
    Broj Tablica <input type="text" name="tablica" id="t" value="">
    Dodaj KM <input type="number" name="km" id="km" value="">
    <input type="submit" value="Posalji" id="dugme">

</form>

@endsection