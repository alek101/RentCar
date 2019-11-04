@extends('mainPage')
@section('Page')

{{-- @php
    var_dump($niz);
@endphp --}}

<h3>Buduce Rezervacije</h3>

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
            <th>Otkazi</th>
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
    
                    ."<td> <a href='/rezervacijeInfo/cancel/".$auto->id."' class='cancel'>Otkazi</td>"
    
             . "</tr>";
            !!}
        @endforeach
    </table>

    <script src="">
        [...document.querySelectorAll('.cancel')].map(c=>c.addEventListener('click',function(e)
        {
            e.target.parentElement().parentElement().remove();
        }))
    </script>

@endsection