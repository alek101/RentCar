@extends('mainPage')
@section('Page')

{{-- @php
    var_dump($cars);
    var_dump($models);
@endphp --}}

{{-- <div class='forma'> --}}
    {{-- @csrf  --}}
    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" id='token'> --}}
     {{-- <input type="date" name="dateStart" id="start" value="{{$dateStart}}" hidden>
     <input type="date" name="dateEnd" id="end" value="{{$dateEnd}}" hidden>
    Model 
    <select name="model" id="model">
        @foreach ($models as $model)
            {!! "<option value='$model'> $model </option>" !!}
        @endforeach
    </select>
    Ime <input type="text" name="ime" id="ime" required>
    Email <input type="email" name="email" id="email" required>
    Telefon <input type="number" name="telefon" id="telefon">
    Komentar <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
    <button id="dugme">Posalji</button> --}}
{{-- </div> --}}

<form >
    @csrf 
    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" id='token'> --}}
     <input type="date" name="dateStart" id="start" value="{{$dateStart}}" hidden>
     <input type="date" name="dateEnd" id="end" value="{{$dateEnd}}" hidden>
    Model 
    <select name="model" id="model">
        @foreach ($models as $model)
            <?php $pom=$cene[$model] ?>
            {!! "<option value='$model'> $model - cena: $pom </option>" !!}
        @endforeach
    </select>
    Ime <input type="text" name="ime" id="ime" required>
    Email <input type="email" name="email" id="email" required>
    Telefon <input type="number" name="telefon" id="telefon">
    Komentar <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
    <input type="submit" value="Posalji" id='dugme'>

</form>

<div class="response"></div>

<script>
        document.querySelector('#dugme').addEventListener('click',function(e)
        {
            e.preventDefault();

            let dateStart,dateEnd,model,ime,telefon,email,comment;

            dateStart=document.querySelector('#start').value;
            dateEnd=document.querySelector('#end').value;
            model=document.querySelector('#model').value;
            ime=document.querySelector('#ime').value;
            email=document.querySelector('#email').value;
            telefon=document.querySelector('#telefon').value || 000;
            comment=document.querySelector('#comment').value || 'no comment';
    
            let niz=
            {
                dateStart:dateStart,
                dateEnd:dateEnd,
                model:model,
                ime:ime,
                email:email,
                telefon:telefon,
                comment:comment  
            }
    
            console.log(niz);
            // let fd = new FormData();
            // fd.append("dateStart", dateStart);
            // fd.append("_token", document.querySelector('input[name="_token"]').value);

            let opcije={
                method: "POST",
                body: niz,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                }
                // header: new Headers()
            }


    
            fetch('/rezervacija/posalji4',opcije)
                .then(resp=>resp.text())
                .then(jsn=>alert(jsn));
        })
    
    </script>
@endsection