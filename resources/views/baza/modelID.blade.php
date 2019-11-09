@extends('mainPage')
@section('Page')

<form class="formZakazivanje" method="POST" action="/baza/posalji2">
    <div class="flexColumn">
        <div class="flexRow">
                @csrf 
        </div>
        <div class="flexRow">
            <label for="Model">Model Automobila<input type="text" name="Model" id="Model"></label>
        </div>
        <div><input type="submit" value="Posalji" id='dugme'></div> 
</form>

@endsection