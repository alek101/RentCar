@extends('mainPage')
@section('Page')

<h2>Kritični automobili</h2>

<div class="margin_20"><label for="filter">Filter tabela: <input type="text" id="filter" class='filter'></label></div>

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

    @foreach ($niz as $auto)
        
        @php
            $date=explode('-',$auto->registracija);
            $date=array_reverse($date);
            $auto->registracija=implode('.',$date).".";
        @endphp

        {!! 
        "<tr>" .

            "<td> <a href='/auto/info/$auto->sasija'>" .
                $auto->sasija
                . "</a></td>".

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

                "<td class='date'>" .
                $auto->registracija
                . "</td>".

                "<td>" .
                $auto->mali_servis
                . "</td>".

                "<td>" .
                $auto->veliki_servis
                . "</td>";
            !!}
            @if($auto->isticanje_registracije<=30)
                {!! "<td class='bckRed'>" .
                $auto->isticanje_registracije
                . "</td>" !!}
            @else
            {!! "<td>" .
                    $auto->isticanje_registracije
                . "</td>"; !!}
            @endif
            @if ($auto->predjeno_km_mali>=10000)
                {!! "<td class='bckRed'>" .
                        $auto->predjeno_km_mali
                        . "</td>"; !!}
            @else
                {!! 
                "<td>" .
                        $auto->predjeno_km_mali
                        . "</td>";
                 !!}
            @endif
            @if ($auto->predjeno_km_veliki>=100000)
            {!! 
                "<td class='bckRed'>" .
                $auto->predjeno_km_veliki
                . "</td>"; !!}
            @else
                {!! 
                "<td>" .
                $auto->predjeno_km_veliki
                . "</td>"; !!}
            @endif
                 {!! "<td>
                        <button class='zakaziServis' data-sasija=".$auto->sasija.">Servis</button>
                     </td></tr>"; !!}
                        
                    
                    
    @endforeach
</table>



@endsection