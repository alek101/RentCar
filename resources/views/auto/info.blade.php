@extends('mainPage')
@section('Page')

{{-- @php
    var_dump($niz);
@endphp --}}

<div class="margin_20"><label for="filter">Filter tabela: <input type="text" id="filter" class='filter'></label></div>

<div class="prazan"></div>

<h3>Osnonvne Informacije</h3>
<table>
        <tr>
            <th>Broj Šasije</th>
            <th>Broj Saobraćajne</th>
            <th>Broj Tablica</th>
            <th>Model</th>
            <th>Godište</th>
            <th>Kilometraža</th>
            <th>Datum Registracije</th>
            <th>Radjen Mali</th>
            <th>Radjen Veliki</th>
            <th>Isticanje registracije</th>
            <th>Predjeno od Malog</th>
            <th>Predjeno od Velikog</th>
            <th>Zakaži Servis</th>
           
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

        @php
            $date=explode('-',$auto->registracija);
            $date=array_reverse($date);
            $auto->registracija=implode('.',$date).".";
        @endphp
    
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

                   ."<td>
                        <button class='zakaziServis' data-sasija='".$auto->sasija."'>Servis</button>
                     </td>"
    
             . "</tr>";
            !!}
        
    </table>

    <h3>Dodaj kilometražu</h3>
<form method="POST" action="/prijem/izmeniKM" class="formAddKM">
    @csrf
    <input type="text" name='id' value="<?=$auto->sasija?>" id="id" hidden required>
    Dodaj KM <input type="number" name="km" id="km" value="" required>
    <input type="submit" value="Dodaj" id="dugme2">

</form>

{{-- <h3>
    <a href="/kriticni/{{$auto->sasija}}">Zakazi Servis</a>
</h3> --}}

{{-- <h3>
    Zakazi Servis
</h3> --}}



<h3>Servisna knjižica</h3>

<table>
        <tr>
            
            <th>Datum</th>
            <th>Tip Servisa</th>
            <th>Kilometraža</th>
            <th>Opis</th>
        </tr>
    
        <tr>
            
            <th></th>
            <th></th>
            <th>km</th>
            <th></th>
        </tr>
    
        @foreach ($knjizica as $unos)

        @php
            $date=explode('-',$unos->datum);
            $date=array_reverse($date);
            $unos->datum=implode('.',$date).".";
        @endphp

            {!! 
            "<tr>" .
    
                "<td class='date'>" .
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

    <h3>Buduće Rezervacije</h3>

    <button class="dugme" id="addFilterReservation" data-tablice={!! $auto->tablica !!}>Dodatni Filter</button>

    <table>
        <tr>
            <th>ID rezervacije</th>
            <th>Ime</th>
            <th>Mejl</th>
            <th>Telefon</th>
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
    
                    ."<td><button class='obrisi' data-link='/auto/cancelReservation/".$rez->id."'>Otkazi</button></td>"
    
             . "</tr>";
            !!} 
         @endforeach
    </table>

    <script>
        //ubacujemo ime tablica u filter i idemo na stranicu sa rezervacijama
        document.querySelector('#addFilterReservation').addEventListener('click',function(e)
        {
            let tablice=e.target.getAttribute('data-tablice');
            sessionStorage.setItem('filterTabela',tablice);
            window.open('/rezervacijeInfo/all','_self');
        });

    </script>

@endsection