@extends('mainPage')
@section('Page')

<form class="formZakazivanje" method="POST" action="/baza/posalji1">
    <div class="flexColumn">
        <div class="flexRow">
                @csrf 
        </div>
        <div class="flexRow">
            <label for="Model">Model Automobila<input type="text" name="Model" id="Model"></label>
            <label for="slika">Ime fajla slike<input type="text" name="slika" id="slika"></label>
        </div>
        <div class="flexRow">
            <label for="Klasa">
                Klasa
                <select name="Klasa" id="Klasa">
                    <option value="mala">mala</option>
                    <option value="srednja">srednja</option>
                    <option value="velika">velika</option>
                    <option value="luksuzna">luksuzna</option>
                </select>
            </label>
            <label for="Tip_menjaca">
                Tip menjaca
                <select name="Tip_menjaca" id="Tip_menjaca">
                    <option value="manuelni">manuelni</option>
                    <option value="automatski">automatski</option>
                </select>
            </label>
        </div>
        <div class="flexRow">
            <label for="Broj_sedista">Broj Sedista<input type="text" name="Broj_sedista" id="Broj_sedista"></label>
            <label for="Broj_vrata">Broj Vrata<input type="text" name="Broj_vrata" id="Broj_vrata"></label>
            <label for="Broj_torbi">Broj Torbi<input type="text" name="Broj_torbi" id="Broj_torbi"></label>
        </div>
        <div class="flexRow">
            <label for="opis">Opis <br><textarea name="opis" id="opis" cols="100" rows="10"></textarea></label>
        </div>
        <div class="flexRow">
                <label for="cena_3">Cena za do 3 dana<input type="number" name="cena_3" id="cena_3"></label>
                <label for="cena_7">Cena za do 7 dana<input type="number" name="cena_7" id="cena_7"></label>
                <label for="cena_max">Cena za vise od 7 dana<input type="number" name="cena_max" id="cena_max"></label>
        </div>
        <div><input type="submit" value="Posalji" id='dugme'></div>  
    </div>
</form>

@endsection