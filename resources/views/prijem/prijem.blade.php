@extends('mainPage')
@section('Page')

<form method="POST" action="/prijem/izmeniKM">
    @csrf
    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" id='token'> --}}
    {{-- Broj Sasije  --}}
    <div class="flexRow">
        <input type="text" name='id' value="" id="id" hidden>
        <label for="t">Broj Tablica <input type="text" name="tablica" id="t" value=""></label>
        <label for="km">Dodaj KM <input type="number" name="km" id="km" value=""></label>
    </div>
    
    <div class="flexRow">
        <input type="submit" value="Posalji" id="dugme">
    </div>
    

</form>

@endsection