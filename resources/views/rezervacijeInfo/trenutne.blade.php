@extends('mainPage')
@section('Page')

{{-- @php
    var_dump($niz);
@endphp --}}

<div class="margin_20"><label for="filter">Filter tabela: <input type="text" id="filter" class='filter'></label></div>

<div class="prazan"></div>

<h3>Rezervacije u toku</h3>

<table>
        <tr>
            <th>ID Rezervacije</th>
            <th>Ime</th>
            <th>Mejl</th>
            <th>Telefon</th>
            <th>Tablice</th>
            <th>Model</th>
            <th>Datum početka</th>
            <th>Datum završetka</th>
            <th>Cena</th>
            <th>Opis</th>
            <th>Produži/Skrati</th>
            <th>Otkaži</th>
        </tr>
    
        
    
        @foreach ($niz as $rez)
            {!! 
            "<tr>" .
    
                "<td>" .
                    $rez->id
                    . "</td>".

                    "<td>" .
                    $rez->ime
                    . "</td>".
    
                    "<td>" .
                    $rez->meil
                    . "</td>".
    
                    "<td>" .
                    $rez->telefon
                    . "</td>".
    
                    "<td>" .
                    $rez->tablice
                    . "</td>".
    
                    "<td>" .
                    $rez->model
                    . "</td>";
            !!}
            @if ($rez->start==date('Y-m-d'))
            @php
                $date=explode('-',$rez->start);
                $date=array_reverse($date);
                $rez->start=implode('.',$date).".";
            @endphp
            {!! 
                "<td class='date bckRed'>" .
                $rez->start
                . "</td>";
            !!}
        @else
            @php
                $date=explode('-',$rez->start);
                $date=array_reverse($date);
                $rez->start=implode('.',$date).".";
            @endphp
            {!! "<td class='date'>" .
                $rez->start
                . "</td>";
            !!}
        @endif
        @if ($rez->finish==date('Y-m-d'))
            @php
                $date=explode('-',$rez->finish);
                $date=array_reverse($date);
                $rez->finish=implode('.',$date).".";
            @endphp
            {!! 
                "<td class='date bckRed'>" .
                $rez->finish
                . "</td>";
            !!}
        @else
            @php
                $date=explode('-',$rez->finish);
                $date=array_reverse($date);
                $rez->finish=implode('.',$date).".";
            @endphp
            {!! "<td class='date'>" .
                $rez->finish
                . "</td>";
            !!}
        @endif  
            {!! 
                    "<td>" .
                    $rez->cena
                    . "</td>".

                    "<td>" .
                    $rez->opis
                    . "</td>"
    
                    ."<td><button class='produzi' data-link='/rezervacijeInfo/extendForm/$rez->id'>Izmeni</button></td>"

                    ."<td><button class='obrisi' data-link='/rezervacijeInfo/cancelReservation/$rez->id'>Otkaži</button></td>"
    
             . "</tr>";
            !!}
        @endforeach
    </table>

@endsection