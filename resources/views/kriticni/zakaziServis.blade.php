@extends('mainPage')
@section('Page')

@php
    // echo $id;
@endphp

<form method="POST" action="/kriticni/findServiseDate">
    <div class="flexRow">@csrf</div>
    <div class="flexRow">
        <label for="id"> Broj Sasije <input type="text" name='id' value="<?=$id?>" id="id" required></label>
        <label for="brojDana"> Broj Dana <input type="number" name="brojDana" id="brojDana" value="1" required></label>
    </div>
    <div class="flexRow"><input type="submit" value="Posalji" id="dugme"></div>
    
    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" id='token'> --}}
   
   
    

</form>

<a href="https://www.animatedimages.org/cat-cars-67.htm"><img src="https://www.animatedimages.org/data/media/67/animated-car-image-0125.gif" border="0" alt="animated-car-image-0125" /></a>

{{-- <iframe src="iframe" frameborder="0"></iframe> --}}

{{-- <script src={{ URL::asset('js/jquery.js') }}></script> --}}



<script>
    // document.querySelector('#dugme').addEventListener('click',function(e)
    // {
    //     e.preventDefault();
    //     let id=document.querySelector('#id').value;
    //     let broj=document.querySelector('#brojDana').value;

    //     // console.log(id,broj);

    //     let niz={
    //         // _token: _token,
    //         id:id,
    //         brojDana:broj
    //     }

    //     let opcije={
    //         method: "POST",
    //         body: JSON.stringify(niz),
    //         headers: {
    //             'X-CSRF-Token': document.querySelector('#token').value
    //         }
    //     }

    //     fetch('/kriticni/posalji1',opcije)
    //     .then(resp=>resp.text())
    //     .then(txt=>alert(txt))
    //     .then(window.open('/'));
    // })

</script>
@endsection