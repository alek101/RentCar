@extends('mainPage')
@section('Page')

{{-- @php
    var_dump($niz);
@endphp --}}

<div class="margin_20"><label for="filter">Filter tabela: <input type="text" id="filter" class='filter'></label></div>

<div class="prazan"></div>

<h3>Sve Rezervacije</h3>

<p>Ukoliko filter nije aktivan, prikazaće se buduće rezervacije u vremenskom periodu od 90 dana.</p>

<form method="POST" action="/rezervacijeInfo/allReservationForm" class="sveRez">
    <div class="flexColumn">
        <div>@csrf</div>
        <div class="flexRow">
            <label for="selector">
                Kriterijum: <br>
                <select name="selector" id="selector">
                    <option value="datum">Po Datumu</option>
                    <option value="broj">Po Broju Unosa</option>
                </select>
            </label>
        </div>
        <div class="flexRow sDate">
            <label for="start">Početni datum <input type="date" name="dateStart" id="start"></label>
            <label for="end">Krajnji datum <input type="date" name="dateEnd" id="end"></label>
        </div>
        <div class="flexRow brUnos cardDisapear">
            <label for="num">Broj Zadnjih Unosa <br> <input type="number" name="num" id="num"></label>
        </div>
        <div class="flexRow">
            <label for="order">
                Za opadajuće/rastuće vreme: <br>
                <select name="order" id="order">
                    <option value="DESC">Opadajuće</option>
                    <option value="ASC">Rastuće</option>
                </select>
            </label>
        </div>
        <div><input type="submit" value="Pošalji" id="dugme"> </div>
    </div>
</form>





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

                    ."<td><button class='obrisi' data-link='/rezervacijeInfo/cancelReservationFromRezervacijeInfoPage/$rez->id'>Otkaži</button></td>"
    
             . "</tr>";
            !!}
        @endforeach
    </table>

    <script>
        //menjanje forme
        let selector=document.querySelector('#selector');
        selector.addEventListener('change',function()
        {
            let val=selector.value;

            if(val=="broj")
            {
                document.querySelector('.brUnos').classList.remove('cardDisapear');
                document.querySelector('.sDate').classList.add('cardDisapear');
            }

            if(val=="datum")
            {
                document.querySelector('.brUnos').classList.add('cardDisapear');
                document.querySelector('.sDate').classList.remove('cardDisapear');
            }
        })
    </script>

@endsection