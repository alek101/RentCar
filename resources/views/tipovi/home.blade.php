@extends('mainPage')
@section('Page')

{{-- @php
    var_dump($model);
@endphp --}}

<div class="margin_20"><label for="filter">Filter tabela: <input type="text" id="filter" class='filter'></label></div>

<table>
    <tr>
        <th></th>
        <th>Naziv</th>
        <th>Klasa</th>
        <th>Tip Menjača</th>
        <th>Broj Sedišta</th>
        <th>Broj Vrata</th>
        <th>Broj Torbi</th>
    </tr>

    <button class="dodajModel">Dodaj Novi Model</button>
    {{-- <a href="/tipovi/add">Dodaj</a> --}}

    @foreach ($models as $model)
        {!! 
        "<tr>" .

            "<td>" .
                "<img src=/".($model->slika)." alt='Nema Slike'>"
                
                . "</td>".

                "<td>" .
                $model->Model
                . "</td>".

                "<td>" .
                $model->Klasa
                . "</td>".

                "<td>" .
                $model->Tip_menjaca
                . "</td>".

                "<td>" .
                $model->Broj_sedista
                . "</td>".

                "<td>" .
                    $model->Broj_vrata
                . "</td>".

                "<td>" .
                    $model->Broj_torbi
                . "</td>".

            "</tr>";
        !!}            
    @endforeach
</table>

<script>
    document.querySelector('.dodajModel').addEventListener('click', function(e)
    {
        window.open("/tipovi/add");
    })
</script>

@endsection