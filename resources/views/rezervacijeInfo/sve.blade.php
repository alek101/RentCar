@extends('mainPage')
@section('Page')

{{-- @php
    var_dump($niz);
@endphp --}}

<h3><a href="/rezervacijeInfo">Buduce rezervacije</a></h3>

<form method="POST" action="/rezervacijeInfo/forma1">
    @csrf
    Broj Unosa <input type="number" name="num" id="">
    Pocetni datum <input type="date" name="dateStart" id="">
    Krajnji datum <input type="date" name="dateEnd" id="">
<input type="submit" value="Posalji">

</form>





<table>
        <tr>
            <th>Ime</th>
            <th>Mejl</th>
            <th>Telefon</th>
            <th>Tablice</th>
            <th>Model</th>
            <th>Datum pocetka</th>
            <th>Datum zavrsetka</th>
            <th>Cena</th>
            <th>Opis</th>
        </tr>
    
        
    
        @foreach ($niz as $auto)
            {!! 
            "<tr>" .
    
                "<td>" .
                    $auto->ime
                    . "</td>".
    
                    "<td>" .
                    $auto->meil
                    . "</td>".
    
                    "<td>" .
                    $auto->telefon
                    . "</td>".
    
                    "<td>" .
                    $auto->tablice
                    . "</td>".
    
                    "<td>" .
                    $auto->model
                    . "</td>".
    
                    "<td>" .
                    $auto->start
                    . "</td>".
    
                    "<td>" .
                    $auto->finish
                    . "</td>".
    
                    "<td>" .
                    $auto->cena
                    . "</td>".

                    "<td>" .
                    $auto->opis
                    . "</td>"
    
    
             . "</tr>";
            !!}
        @endforeach
    </table>

    <script src="">
       
    </script>

@endsection