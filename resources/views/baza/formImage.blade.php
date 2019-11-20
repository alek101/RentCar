@extends('mainPage')
@section('Page')

<form class="formZakazivanje" method="POST" enctype="multipart/form-data" action="/baza/posaljiSliku">
    <div class="flexColumn">
        <div class="flexRow">
                @csrf 
        </div>
        
        <div class="flexRow">
            <label for="slika">Slika: <input type="file" name="slika" id="slika"></label>
            <label for="naziv">Naziv slike sa ekstenzijom:<input type="text" name="nazivSlike" id="naziv"></label>
        </div>
        <div><input type="submit" value="Posalji" id='dugme'></div> 
    </div>
</form>

<a href="https://www.animatedimages.org/cat-photographers-1425.htm"><img src="https://www.animatedimages.org/data/media/1425/animated-photographer-image-0028.jpg" border="0" alt="animated-photographer-image-0028" /></a>


@endsection