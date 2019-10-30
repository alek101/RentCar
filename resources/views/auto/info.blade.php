@extends('mainPage')
@section('Page')

<h3>Osnonvne Informacije</h3>
<table>
        <tr>
            <th>Broj Sasije</th>
            <th>Broj Saobracajne</th>
            <th>BrojTablica</th>
            <th>Model</th>
            <th>Godiste</th>
            <th>Kilometraza</th>
            <th>Datum Registracije</th>
            <th>Radjen Mali</th>
            <th>Radjen Veliki</th>
            <th>Isticanje registracije</th>
            <th>Predjeno od Malog</th>
            <th>Predjeno od Velikog</th>
           
        </tr>
    
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>god</th>
            <th>km</th>
            <th></th>
            <th>km</th>
            <th>km</th>
            <th>dani</th>
            <th>km</th>
            <th>km</th>
            
        </tr>
    
            {!! 
            "<tr>" .
    
                "<td>" .
                    $auto->sasija
                    . "</td>".
    
                    "<td>" .
                    $auto->saobracajna
                    . "</td>".
    
                    "<td>" .
                    $auto->tablica
                    . "</td>".
    
                    "<td>" .
                    $auto->model
                    . "</td>".
    
                    "<td>" .
                    $auto->godiste
                    . "</td>".
    
                    "<td>" .
                    $auto->kilometraza
                    . "</td>".
    
                    "<td>" .
                    $auto->registracija
                    . "</td>".
    
                    "<td>" .
                    $auto->mali_servis
                    . "</td>".
    
                    "<td>" .
                    $auto->veliki_servis
                    . "</td>".
    
                    "<td>" .
                    $auto->isticanje_registracije
                    . "</td>".
    
                    "<td>" .
                    $auto->predjeno_km_mali
                    . "</td>".
    
                    "<td>" .
                    $auto->predjeno_km_veliki
                    . "</td>"
    
             . "</tr>";
            !!}
        
    </table>

    <h3>Dodaj kilometrazu</h3>
<form method="POST" action="/prijem/izmeniKM">
    @csrf
    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" id='token'> --}}
    {{-- Broj Sasije  --}}
    <input type="text" name='id' value="<?=$auto->sasija?>" id="id" hidden>
    Dodaj KM <input type="number" name="km" id="km" value="">
    <input type="submit" value="Posalji" id="dugme">

</form>

<h3>
    <a href="/kriticni/{{$auto->sasija}}">Zakazi Servis</a>
</h3>

<h3>Servisna knjizica</h3>

<table>
        <tr>
            <th>Datum</th>
            <th>Tip Servisa</th>
            <th>Kilometraza</th>
            <th>Opis</th>
        </tr>
    
        <tr>
            <th></th>
            <th></th>
            <th>km</th>
            <th></th>
        </tr>
    
        @foreach ($knjizica as $unos)
            {!! 
            "<tr>" .
    
                "<td>" .
                    $unos->datum
                    . "</td>".
    
                    "<td>" .
                    $unos->tip
                    . "</td>".
    
                    "<td>" .
                    $unos->km
                    . "</td>".
    
                    "<td>" .
                    $unos->opis
                    . "</td>"
    
             . "</tr>";
            !!}
        @endforeach
    </table>

@endsection