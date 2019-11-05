@extends('mainPage')
@section('Page')


<form method="POST" action="/rezervacija/posalji2" >
    @csrf
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
    Email <input type="email" name="email" id="email">
    Telefon <input type="number" name="telefon" id="telefon">
    Komentar <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
    <input type="submit" value="Posalji" id="dugme">
</form>

@endsection