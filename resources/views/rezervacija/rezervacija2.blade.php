@extends('mainPage')
@section('Page')

DEPRICATED

<form class="formZakazivanje" method="POST" action="/rezervacija/posalji2">
        <div class="flexColumn">
            <div class="flexRow">
                    @csrf 
                    <input type="date" name="dateStart" id="start" value="{{$dateStart}}" hidden>
                    <input type="date" name="dateEnd" id="end" value="{{$dateEnd}}" hidden>
            </div>
            <div class="flexRow">
                <label for="model">Model 
                        <select name="model" id="model">
                            @foreach ($models as $model)
                                <?php $pom=$cene[$model] ?>
                                {!! "<option value='$model'> $model - cena: $pom </option>" !!}
                            @endforeach
                        </select></label>
            
                <label for="ime"> Ime <input type="text" name="ime" id="ime" required></label>
                <label for="email">Email <input type="email" name="email" id="email" required></label>
                <label for="telefon">Telefon <input type="number" name="telefon" id="telefon"></label>
            </div>
            <div>
                <label for="comment"> Komentar <br><textarea name="comment" id="comment" cols="30" rows="10"></textarea></label>
            </div>
            <div><input type="submit" value="Posalji" id='dugme'></div>  
        </div>
    </form>

@endsection