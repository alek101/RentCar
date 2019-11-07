@extends('mainPage')
@section('Page')

{{-- @php
    var_dump($niz);
@endphp --}}

<div class="prazan"></div>

<h3>Buduce Rezervacije</h3>

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
    
                    // ."<td> <a href='/rezervacijeInfo/cancel/".$auto->id."' class='cancel'>Otkazi</td>"
                        ."<td><button class='obrisi' data-link='/rezervacijeInfo/cancel/$auto->id'>Otkazi</button></td>"
    
             . "</tr>";
            !!}
        @endforeach
    </table>

    <script>
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
    </script>

@endsection