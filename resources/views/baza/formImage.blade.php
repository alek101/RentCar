@extends('mainPage')
@section('Page')
DEPRICATED

<form class="formZakazivanje" method="POST" enctype="multipart/form-data" action="/baza/posaljiSliku">
    <div class="flexColumn">
        <div class="flexRow">
                @csrf 
        </div>
        
        <div class="flexRow">
            <label for="slika">Slika: <input type="file" name="slika" id="slika"></label>
            <label for="slikaIme">Naziv slike sa ekstenzijom<input type="text" name="slikaIme" id="slikaIme" required></label>
        </div>
        <div><input type="submit" value="Posalji" id='dugme'></div> 
    </div>
</form>




@endsection