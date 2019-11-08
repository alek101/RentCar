@extends('mainPage')
@section('Page')

@php
    // echo $id;
@endphp

<form method="POST" action="/kriticni/posalji1">
    @csrf
    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" id='token'> --}}
    Broj Sasije <input type="text" name='id' value="<?=$id?>" id="id">
    Broj Dana <input type="number" name="brojDana" id="brojDana" value="1">
    <input type="submit" value="Posalji" id="dugme">

</form>

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