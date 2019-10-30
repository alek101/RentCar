@extends('mainPage')
@section('Page')

<h3>Za produzenje registracije, izaberite opciju.</h3>

<form method="POST" action="/servis/finish">
    @csrf
    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" id='token'> --}}
    Broj Sasije <input type="text" name='id' value="<?=$id?>" id="id">
    Tip <select name="tip" id="tip">
        <option value="mali">Mali</option>
        <option value="veliki">Veliki</option>
        <option value="registracija">Registracija</option>
        <option value="cancel">Otkazi</option>
    </select>
    Datum Servisa/Novo Vazanje Registracije <input type="date" name="datum" id="datum" value='<?php echo date("Y-m-d")?>'>
    Opis <textarea name="opis" id="opis" cols="30" rows="10"></textarea>
    
    <input type="submit" value="Posalji" id="dugme">

</form>

@endsection