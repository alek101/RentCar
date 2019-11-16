@extends('mainPage')
@section('Page')

<form method="POST" action="/prijem/izmeniKM">
    @csrf
    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" id='token'> --}}
    {{-- Broj Sasije  --}}
    <div class="flexRow">
        <label for="id"></label><input type="text" name='id' value="" id="id" hidden></label>
    </div>
    <div class="flexRow">
        <label for="t">Broj Tablica <input type="text" name="tablica" id="t" value=""></label>
        <label for="km">Dodaj KM <input type="number" name="km" id="km" value="" required></label>
    </div>
    
    <div class="flexRow">
        <input type="submit" value="Posalji" id="dugme">
    </div>
    

</form>

<a href="https://www.animatedimages.org/cat-cars-67.htm"><img src="https://www.animatedimages.org/data/media/67/animated-car-image-0330.gif" border="0" alt="animated-car-image-0330" /></a>

@endsection