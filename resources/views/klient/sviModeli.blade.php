@extends('index')
@section('PageF')

<div class="margin_20"><label for="filter">Filter tabela: <input type="text" id="filter" class='filter'></label></div>

<table>
    <tr>
        <th></th>
        <th>Naziv</th>
        <th>Klasa</th>
        <th><img class='icon' src='{!! asset('/images/icons/solid--car-gears.svg') !!}' alt='Tip Menjaca: '></th>
        <th><img class='icon' src='{!! asset('/images/icons/solid--car-door.svg') !!}' alt='Broj Vrata: '></th>
        <th><img class='icon' src='{!! asset('/images/icons/solid--car-seat.svg') !!}' alt='Broj Sedista: '></th>
        <th><img class='icon' src='{!! asset('/images/icons/solid--big-bag.svg') !!}' alt='Broj Torbi: '></th>
    </tr>

    @foreach ($models as $model)
        {!! 
        "<tr>" .

            "<td>" .
                "<img src=".($model->slika)." alt='Nema Slike'>"
                
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



@endsection