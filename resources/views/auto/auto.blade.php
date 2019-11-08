@extends('mainPage')
@section('Page')

<div class="margin_20"><label for="filter">Filter tabela: <input type="text" id="filter" class='filter'></label></div>

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
            <th>Detaljnije</th>
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
            <th></th>
        </tr>
    
        @foreach ($niz as $auto)
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
    
                    ."<td> <a href='/auto/".$auto->sasija."'>Detaljnije</td>"
    
    
    
             . "</tr>";
            !!}
        @endforeach
    </table>

@endsection