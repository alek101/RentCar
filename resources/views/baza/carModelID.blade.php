@extends('mainPage')
@section('Page')

<form class="formZakazivanje" method="POST" action="/baza/car/getFormChange">
    <div class="flexColumn">
        <div class="flexRow">
                @csrf 
        </div>
        <div class="flexRow">
            <label for="selector">
                <select name="selector" id="selector">
                    <option value="tablice" selected>Po tablicama</option>
                    <option value="sasija">Po broju šasije</option>
                </select>
            </label>
        </div>
        <div class="flexRow">
            <label for="Broj_sasije" class="labSas disapear">Broj Šasije<input type="text" name="Broj_sasije" id="Broj_sasije"></label>
            <label for="Broj_registarskih_tablica" class="labTab">Broj Tablica<input type="text" name="Broj_registarskih_tablica" id="Broj_registarskih_tablica"></label>
        </div>
        <div><input type="submit" value="Pošalji" id='dugme'></div> 
</form>

<script>
    //ako postoje tablice u sess stor, upisi ih u formu
    let storedPlates=sessionStorage.getItem('filterTabela');
    if(storedPlates!=null)
    {
        document.querySelector('#Broj_registarskih_tablica').value=storedPlates;
    }
    //izmena forme
    document.querySelector('#selector').addEventListener('change',function()
    {
        document.querySelector('.labSas').classList.toggle('disapear');
        document.querySelector('.labTab').classList.toggle('disapear');
    })
</script>

@endsection