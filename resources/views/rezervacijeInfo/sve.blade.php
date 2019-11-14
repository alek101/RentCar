@extends('mainPage')
@section('Page')

{{-- @php
    var_dump($niz);
@endphp --}}

<div class="margin_20"><label for="filter">Filter tabela: <input type="text" id="filter" class='filter'></label></div>

<div class="prazan"></div>

<h3>Sve Rezervacije</h3>

<p>Ukoliko filter nije aktivan, prikazace se poslednjih 50 unosa.</p>

<form method="POST" action="/rezervacijeInfo/allReservationForm" class="sveRez">
    <div class="flexColumn">
        <div>@csrf</div>
        <div class="flexRow">
            <label for="num">Broj Zadnjih Unosa <br> <input type="number" name="num" id="num"></label>
        </div>
        <div class="flexRow">Ili</div>
        <div class="flexRow">
            <label for="start">Pocetni datum <input type="date" name="dateStart" id="start"></label>
            <label for="end">Krajnji datum <input type="date" name="dateEnd" id="end"></label>
        </div>
        <div class="flexRow">
            <label for="order">
                Za opadajuce/rastuce vreme: <br>
                <select name="order" id="order">
                    <option value="DESC">Opadajuce</option>
                    <option value="ASC">Rastuce</option>
                </select>
            </label>
        </div>
        <div><input type="submit" value="Posalji" id="dugme"> </div>
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
            <th>Datum pocetka</th>
            <th>Datum zavrsetka</th>
            <th>Cena</th>
            <th>Opis</th>
            <th>Produži/Skrati</th>
            <th>Otkazi</th>
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

                    ."<td><button class='obrisi' data-link='/rezervacijeInfo/cancelReservation/$auto->id'>Otkazi</button></td>"
    
             . "</tr>";
            !!}
        @endforeach
    </table>

    <script>
        let butoniProduzi=[...document.querySelectorAll('.produzi')];
        butoniProduzi.map(b=>b.addEventListener('click', function()
        {
            window.open(b.getAttribute('data-link'));
        }));

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