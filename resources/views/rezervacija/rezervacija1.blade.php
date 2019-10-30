@extends('mainPage')
@section('Page')

<form method="POST" action="/rezervacija/posalji1">
    @csrf
    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" id='token'> --}}
    Pocetak <input type="date" name="dateStart" id="start" value="">
    Zavrsetak <input type="date" name="dateEnd" id="end" value="">
    <input type="submit" value="Posalji" id="dugme">

</form>
@endsection