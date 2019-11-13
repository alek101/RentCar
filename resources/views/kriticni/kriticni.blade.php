@extends('mainPage')
@section('Page')

<h2>Kritični automobili</h2>

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
        <th>Zakazi Servis</th>
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
                {{-- {!! "<td> <a href='/kriticni/".$auto->sasija."'>Zakazi Servis</td>"
                    . "</tr>"; !!} --}}
                 {!! "<td>
                        <button class='zakaziServis' date-sasija=".$auto->sasija.">Servis</button>
                     </td></tr>"; !!}
                        
                    
                    
    @endforeach
</table>

<a href="https://www.animatedimages.org/cat-cars-67.htm"><img src="https://www.animatedimages.org/data/media/67/animated-car-image-0530.gif" border="0" alt="animated-car-image-0530" /></a>

<script>
        // let sasija=document.querySelector('#id').value;
        // document.querySelector('.zakaziServis').addEventListener('click',function()
        // {
        //     window.open("/kriticni/"+sasija);
        // })

        let dugmici=[...document.querySelectorAll('.zakaziServis')];
        dugmici.map(c=>c.addEventListener('click',function(e)
        {
            let sasija=e.target.getAttribute("date-sasija");
            window.open("/kriticni/"+sasija);
        }))
</script>

@endsection