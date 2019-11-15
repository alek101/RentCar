@extends('mainPage')
@section('Page')

@php
    // echo $id;
    // echo "SERVIS 2";
    
@endphp

<form method="POST" action="/kriticni/sheduleServise">
    
    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" id='token'> --}}
    <div class="flexRow">@csrf</div>
    <div class="flexRow">
        <label for="id" class="w33">Broj Sasije <input type="text" name='id' value="<?=$id?>" id="id"></label>
        <label for="start" class="w33">Pocetak <input type="date" name="dateStart" id="start" value="{{ $dateStart }}"></label>
        <label for="end" class="w33">Zavrsetak <input type="date" name="dateEnd" id="end" value="{{$dateEnd}}"></label>
    </div>
    <div class="flexRow"><input type="submit" value="Posalji" id="dugme"></div>
</form>

<a href="https://www.animatedimages.org/cat-cars-67.htm"><img src="https://www.animatedimages.org/data/media/67/animated-car-image-0161.gif" border="0" alt="animated-car-image-0161" /></a>

@endsection