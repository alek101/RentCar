@extends('mainPage')
@section('Page')

{{-- @php
    var_dump($niz);
@endphp --}}

<div class="margin_20"><label for="filter">Filter tabela: <input type="text" id="filter" class='filter'></label></div>

{{-- <div class="prazan"></div> --}}

<h3>Sve Rezervacije</h3>

<p>Ukoliko filter nije aktivan, prikazace se poslednjih 50 unosa.</p>

<form method="POST" action="/rezervacijeInfo/forma1" class="sveRez">
    <div class="flexColumn">
        <div>@csrf</div>
        <div class="flexRow">
            <label for="num">Broj Zadnjih Unosa <input type="number" name="num" id="num" ></label>
        </div>
        <div class="flexRow">
            <label for="start">Pocetni datum <input type="date" name="dateStart" id="start"></label>
            <label for="end">Krajnji datum <input type="date" name="dateEnd" id="end"></label>
        </div>
        <div class="flexRow">
            <label for="rezID">ID Rezervacije <input type="number" name="id" id="rezID"></label>
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
            {{-- <th>Otkazi</th> --}}
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
    
                    // ."<td><button class='obrisi' data-link='/rezervacijeInfo/cancel/$auto->id'>Otkazi</button></td>"
    
             . "</tr>";
            !!}
        @endforeach
    </table>

    {{-- <script>
        let butoniObrisi=[...document.querySelectorAll('.obrisi')];
        butoniObrisi.map(b=>b.addEventListener('click', function()
        {
            let link=b.getAttribute('data-link');
            let div=document.createElement('div');
            div.className='kartica';
            div.append('Da li ste sigurni?   ');

            let butY=document.createElement('button');
            butY.innerHTML="Da";
            butY.addEventListener('click',function(e)
            {
                window.open(link);
                e.target.parentElement.remove();
            })
            div.appendChild(butY);

            let butN=document.createElement('button');
            butN.innerHTML="Ne";
            butN.addEventListener('click',function(e)
            {
                e.target.parentElement.remove();
            })
            div.appendChild(butN);

            document.querySelector('.prazan').appendChild(div);
        }))
    </script> --}}

@endsection