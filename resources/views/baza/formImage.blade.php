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
        
</form>


<script>
    document.querySelector('#slika').addEventListener('change',function(e)
    {
        let nameImage=document.querySelector('#slika').value.slice(12);
        document.querySelector('#naziv').value=nameImage;
        sessionStorage.setItem('nameImage',nameImage);
    })

</script>



@endsection