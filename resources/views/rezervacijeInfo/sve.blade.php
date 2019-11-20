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
    
        
    
        @foreach ($niz as $auto)
            {!! 
            "<tr>" .
    
                "<td>" .
                    $auto->id
                    . "</td>".

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
    
                    ."<td><button class='produzi' data-link='/rezervacijeInfo/extendForm/$auto->id'>Izmeni</button></td>"

                    ."<td><button class='obrisi' data-link='/rezervacijeInfo/cancelReservation/$auto->id'>Otkaži</button></td>"
    
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
        //produzenje rezervacije ili skracenje
        let butoniProduzi=[...document.querySelectorAll('.produzi')];
        butoniProduzi.map(b=>b.addEventListener('click', function()
        {
            window.open(b.getAttribute('data-link'));
        }));

        //otkazivanje registracije
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
            div2.append('Upišite sledeci broj: ',rand);

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