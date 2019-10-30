@extends('mainPage')
@section('Page')

{{-- @php
    var_dump($cars);
    var_dump($models);
@endphp --}}

<form method="POST" action="/rezervacija/posalji2" target="myFrame">
    @csrf
    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" id='token'> --}}
     <input type="date" name="dateStart" id="start" value="{{$dateStart}}" hidden>
     <input type="date" name="dateEnd" id="end" value="{{$dateEnd}}" hidden>
    Model 
    <select name="model" id="model">
        @foreach ($models as $model)
            {!! "<option value='$model'> $model </option>" !!}
        @endforeach
    </select>
    Ime <input type="text" name="ime" id="ime" required>
    Email <input type="email" name="email" id="email">
    Telefon <input type="number" name="telefon" id="telefon">
    Komentar <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
    <input type="submit" value="Posalji" id="dugme">
    

</form>

<iframe name="myFarme" frameborder="0"></iframe>

<script>
        // document.querySelector('#dugme').addEventListener('click',function(e)
        // {
        //     e.preventDefault();
        //     let id=document.querySelector('#id').value;
        //     let broj=document.querySelector('#brojDana').value;
    
        //     // console.log(id,broj);
    
        //     let niz={
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
    
        //     fetch('/rezervacija/posalji2',opcije)
        //     .then(resp=>resp.text())
        //     .then(txt=>alert(txt))
        // })
    
    </script>
@endsection