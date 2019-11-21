@extends('mainPage')
@section('Page')

<form method="POST" action="/prijem/izmeniKM">
    @csrf
    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" id='token'> --}}
    {{-- Broj Sasije  --}}
    <div class="flexRow">
        <label for="selector">
            <select name="selector" id="selector">
                <option value="tablice" selected>Po tablicama</option>
                <option value="sasija">Po broju šasije</option>
            </select>
        </label>
    </div>
    <div class="flexRow">
        <label for="id" class="labSas disapear">Broj Šasije<input type="text" name='id' value="" id="id"></label>
        <label for="t" class="labTab">Broj Tablica <input type="text" name="tablica" id="t" value=""></label>
        <label for="km">Dodaj KM <input type="number" name="km" id="km" value="" required></label>
    </div>
    
    <div class="flexRow">
        <input type="submit" value="Pošalji" id="dugme">
    </div>
    

</form>



<script>
    //ako postoje tablice u sess stor, upisi ih u formu
    let storedPlates=sessionStorage.getItem('filterTabela');
    if(storedPlates!=null)
    {
        document.querySelector('#t').value=storedPlates;
    }
    //izmena forme
    document.querySelector('#selector').addEventListener('change',function()
    {
        document.querySelector('.labSas').classList.toggle('disapear');
        document.querySelector('.labTab').classList.toggle('disapear');
    })
</script>
@endsection