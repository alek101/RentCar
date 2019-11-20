@extends('mainPage')
@section('Page')

@php
    // echo $id;
@endphp

<form method="POST" action="/kriticni/findServiseDate">
    <div class="flexRow">@csrf</div>
    <div class="flexRow">
        <label for="id"> Broj Šasije <input type="text" name='id' value="<?=$id?>" id="id" required></label>
        <label for="brojDana"> Broj Dana <input type="number" name="brojDana" id="brojDana" value="1" required></label>
    </div>
    <div class="flexRow"><input type="submit" value="Posalji" id="dugme"></div>
    
    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" id='token'> --}}
   
   
    

</form>

<a href="https://www.animatedimages.org/cat-cars-67.htm"><img src="https://www.animatedimages.org/data/media/67/animated-car-image-0125.gif" border="0" alt="animated-car-image-0125" /></a>


@endsection