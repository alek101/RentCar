@extends('mainPage')
@section('Page')

<form class="formZakazivanje" method="POST" action="/baza/car/getFormChange">
    <div class="flexColumn">
        <div class="flexRow">
                @csrf 
        </div>
        <div class="flexRow">
            <label for="Broj_sasije">Broj Šasije<input type="text" name="Broj_sasije" id="Broj_sasije"></label>
            <label for="Broj_registarskih_tablica">Broj Tablica<input type="text" name="Broj_registarskih_tablica" id="Broj_registarskih_tablica"></label>
        </div>
        <div><input type="submit" value="Posalji" id='dugme'></div> 
</form>

<script>
    //ako postoje tablice u sess stor, upisi ih u formu
    let storedPlates=sessionStorage.getItem('filterTabela');
    if(storedPlates!=null)
    {
        document.querySelector('#Broj_registarskih_tablica').value=storedPlates;
    }
</script>

@endsection