@extends('mainPage')
@section('Page')

<form method="POST" action="/rezervacija/posalji1">
    @csrf
    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" id='token'> --}}
    <div class="flexRow">
        <label for="start">Pocetak <input type="date" name="dateStart" id="start" value=""></label>
        <label for="end">Zavrsetak <input type="date" name="dateEnd" id="end" value=""></label>
    </div>
    <div class="flexRow">
        <input type="submit" value="Posalji" id="dugme">
    </div>
    

</form>
@endsection