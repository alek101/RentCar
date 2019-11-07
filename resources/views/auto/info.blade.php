@extends('mainPage')
@section('Page')

<div class="margin_20"><label for="filter">Filter tabela: <input type="text" id="filter" class='filter'></label></div>

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
<form method="POST" action="/prijem/izmeniKM" class="formAddKM">
    @csrf
    <input type="text" name='id' value="<?=$auto->sasija?>" id="id" hidden>
    Dodaj KM <input type="number" name="km" id="km" value="">
    <input type="submit" value="Posalji" id="dugme">

</form>

{{-- <h3>
    <a href="/kriticni/{{$auto->sasija}}">Zakazi Servis</a>
</h3> --}}

<h3>
    Zakazi Servis
</h3>

<button class="zakaziServis">Servis</button>

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

    <script>
        let sasija=document.querySelector('#id').value;
        document.querySelector('.zakaziServis').addEventListener('click',function()
        {
            window.open("/kriticni/"+sasija);
        })
    </script>

@endsection