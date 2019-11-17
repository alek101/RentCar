@extends('mainPage')
@section('Page')

<form class="formZakazivanje" method="POST" enctype="multipart/form-data" action="/baza/model/add">
    <div class="flexColumn">
        <div class="flexRow">
                @csrf 
        </div>
        <div class="flexRow">
            <label for="Model">Model Automobila<input type="text" name="Model" id="Model" required></label>
            <label for="slika">Slika: <input type="file" name="slika" id="slika"></label>
            <label for="slikaIme">Ime slike<input type="text" name="slikaIme" id="slikaIme" required></label>
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
                Tip menjača
                <select name="Tip_menjaca" id="Tip_menjaca">
                    <option value="manuelni">manuelni</option>
                    <option value="automatski">automatski</option>
                </select>
            </label>
        </div>
        <div class="flexRow">
            <label for="Broj_sedista">Broj Sedišta<input type="number" name="Broj_sedista" id="Broj_sedista" required></label>
            <label for="Broj_vrata">Broj Vrata<input type="number" name="Broj_vrata" id="Broj_vrata" required></label>
            <label for="Broj_torbi">Broj Torbi<input type="number" name="Broj_torbi" id="Broj_torbi" required></label>
        </div>
        <div class="flexRow">
            <label for="opis">Opis <br><textarea name="opis" id="opis" cols="100" rows="10" required></textarea></label>
        </div>
        <div class="flexRow">
                <label for="cena_3">Cena za do 3 dana<input type="number" name="cena_3" id="cena_3" required></label>
                <label for="cena_7">Cena za do 7 dana<input type="number" name="cena_7" id="cena_7" required></label>
                <label for="cena_max">Cena za vise od 7 dana<input type="number" name="cena_max" id="cena_max" required></label>
        </div>
        <div><input type="submit" value="Posalji" id='dugme'></div>  
    </div>
</form>

<script>
    //
    let nameImage=sessionStorage.getItem('nameImage');
    if(nameImage!=null)
    {
        document.querySelector('#slikaIme').value=nameImage;
    }

    //da izvadi ime slike iz fajla
    document.querySelector('#slika').addEventListener('change',function(e)
    {
        let nameImage=document.querySelector('#slika').value.slice(12);
        document.querySelector('#slikaIme').value=nameImage;
        sessionStorage.setItem('nameImage',nameImage);
    })


</script>

@endsection