@extends('mainPage')
@section('Page')

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
        <th>Zakazivanje</th>
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

                ."<td> <a href='/kriticni/".$auto->sasija."'>Zakazi Servis</td>"



         . "</tr>";
        !!}
    @endforeach
</table>

@endsection