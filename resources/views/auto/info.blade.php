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
                        <button class='zakaziServis'>Servis</button>
                     </td>"
    
             . "</tr>";
            !!}
        
    </table>

    <h3>Dodaj kilometrazu</h3>
<form method="POST" action="/prijem/izmeniKM" class="formAddKM">
    @csrf
    <input type="text" name='id' value="<?=$auto->sasija?>" id="id" hidden>
    Dodaj KM <input type="number" name="km" id="km" value="">
    <input type="submit" value="Posalji" id="dugme2">

</form>

{{-- <h3>
    <a href="/kriticni/{{$auto->sasija}}">Zakazi Servis</a>
</h3> --}}

{{-- <h3>
    Zakazi Servis
</h3> --}}



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

    <button class="dugme" id="addFilterReservation" data-tablice={!! $auto->tablica !!}>Dodatni Filter</button>

    <table>
        <tr>
            <th>ID rezervacije</th>
            <th>Ime</th>
            <th>Mejl</th>
            <th>Telefon</th>
            <th>Datum pocetka</th>
            <th>Datum zavrsetka</th>
            <th>Cena</th>
            <th>Opis</th>
            <th>Produži/Skrati</th>
            <th>Otkazi</th>
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
                    $rez->start
                    . "</td>".
    
                    "<td>" .
                    $rez->finish
                    . "</td>".
    
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
        let sasija=document.querySelector('#id').value;
        document.querySelector('.zakaziServis').addEventListener('click',function()
        {
            window.open("/kriticni/"+sasija);
        })

        let butoniProduzi=[...document.querySelectorAll('.produzi')];
        butoniProduzi.map(b=>b.addEventListener('click', function()
        {
            window.open(b.getAttribute('data-link'));
        }));

        //ubacujemo ime tablica u filter i idemo na stranicu sa rezervacijama
        document.querySelector('#addFilterReservation').addEventListener('click',function(e)
        {
            let tablice=e.target.getAttribute('data-tablice');
            sessionStorage.setItem('filterTabela',tablice);
            window.open('/rezervacijeInfo/all');
        });

        let butoniObrisi=[...document.querySelectorAll('.obrisi')];
        butoniObrisi.map(b=>b.addEventListener('click', function()
        {
            let link=b.getAttribute('data-link');
            let div=document.createElement('div');
            div.className='kartica';
            div.innerHTML="<h3>Da li ste sigurni?</h3>";

            let div2=document.createElement('div');
            div2.className='flexRow';

            let rand=Math.floor(Math.random()*91)+10;
            div2.append('Upisite sledeci broj: ',rand);

            let div21=document.createElement('div');
            div21.className='flexRow';

            input=document.createElement('input');
            div21.append(input);

            let div3=document.createElement('div');
            div3.className='flexRow';

            let butY=document.createElement('button');
            butY.innerHTML="Da";
            butY.addEventListener('click',function(e)
            {
                if(input.value==rand)
                {
                   window.open(link); 
                }
                e.target.parentElement.parentElement.remove();
            })
            div3.appendChild(butY);

            let butN=document.createElement('button');
            butN.innerHTML="Ne";
            butN.addEventListener('click',function(e)
            {
                e.target.parentElement.parentElement.remove();
            })
            div3.appendChild(butN);

            div.append(div2,div21,div3);
            document.querySelector('.prazan').appendChild(div);
        }))
    </script>

@endsection