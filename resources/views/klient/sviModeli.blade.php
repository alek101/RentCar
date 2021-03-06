@extends('index')
@section('PageF')

{{-- @php
    var_dump($cenovnik);
@endphp --}}
<section class="dodaci">
    <div class="filter_modeli"><label for="filter" class="white">Filter po nazivu: <input type="text" id="filter" class='filter'></label></div>

    <table>
        <tr>
            <th></th>
            <th>Naziv</th>
            <th>Klasa</th>
            <th><img class='icon' src='{!! asset('/images/icons/solid--car-gears.svg') !!}' alt='Tip Menjaca: '></th>
            <th><img class='icon' src='{!! asset('/images/icons/solid--car-door.svg') !!}' alt='Broj Vrata: '></th>
            <th><img class='icon' src='{!! asset('/images/icons/solid--car-seat.svg') !!}' alt='Broj Sedišta: '></th>
            <th><img class='icon' src='{!! asset('/images/icons/solid--big-bag.svg') !!}' alt='Broj Torbi: '></th>
            <th class='cenaZvezdica'>Cena 1-3*</th>
            <th class='cenaZvezdica'>Cena 4-7*</th>
            <th class='cenaZvezdica'>Cena 8+*</th>
        </tr>

        @foreach ($models as $model)

            <?php
                foreach($cenovnik as $item)
                {
                    if($model->Model == $item->Model)
                    {
                        if($item->Max_broj_dana==3)
                        {
                            $cena_3=$item->cena_po_danu;  
                        }

                        if($item->Max_broj_dana==7)
                        {
                            $cena_7=$item->cena_po_danu; 
                        }

                        if($item->Max_broj_dana==12700)
                        {
                            $cena_max=$item->cena_po_danu;  
                        }
                    }
                }
            ?>

            {!! 
            "<tr class='tr_img'>" .

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

                    "<td>" .
                        $cena_3
                    . "</td>".

                    "<td>" .
                        $cena_7
                    . "</td>".

                    "<td>" .
                        $cena_max
                    . "</td>".

                "</tr>";
            !!}            
        @endforeach
    </table>
    
</section>

@endsection