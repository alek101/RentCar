@extends('mainPage')
@section('Page')

<form class="formZakazivanje" method="POST" action="/baza/car/add">
    <div class="flexColumn">
        <div class="flexRow">
                @csrf 
        </div>
        <div class="flexRow">
            <label for="Broj_sasije">Broj sasije<input type="text" name="Broj_sasije" id="Broj_sasije"></label>
            <label for="Broj_saobracajne_dozvole">Broj saobracajne dozvole<input type="text" name="Broj_saobracajne_dozvole" id="Broj_saobracajne_dozvole"></label>
            <label for="Broj_registarskih_tablica">Broj Tablica<input type="text" name="Broj_registarskih_tablica" id="Broj_registarskih_tablica"></label>
        </div>
        <div class="flexRow">
            <label for="Godina_proizvodnje">Godina proizvodnje<input type="number" name="Godina_proizvodnje" id="Godina_proizvodnje" value=<?=date('Y')?>></label>
            <label for="Datum_vazenja_registracije">Vazenje registracije<input type="date" name="Datum_vazenja_registracije" id="Datum_vazenja_registracije"></label>
            <label for="Predjena_km">Predjena kilometraza [km]<input type="number" name="Predjena_km" id="Predjena_km" value=0></label>
        </div>
        <div class="flexRow">
            <label for="Radjen_mali_servis_km">Mali servis [km]<input type="number" name="Radjen_mali_servis_km" id="Radjen_mali_servis_km" value=0></label>
            <label for="Radjen_veliki_servis_km">Veliki servis [km]<input type="number" name="Radjen_veliki_servis_km" id="Radjen_veliki_servis_km" value=0></label>
        </div>
        <div class="flexRow">
            <label for="Servis">
                Servis
                <select name="Servis" id="Servis">
                    <option value="0" selected>Nije na Servisu</option>
                    <option value="1">Jeste na Servisu</option>
                </select>
            </label>
            <label for="Aktivan">
                Aktivan
                <select name="Aktivan" id="Aktivan">
                    <option value="0">Nije Aktivan/Obrisan</option>
                    <option value="1" selected>Aktivan je</option>
                </select>
            </label>
        </div>
        
        <div class="flexRow">
                <label for="Model">
                        Model automobila
                        <select name="Model" id="Model">
                            @foreach ($models as $model)
                                {!! "<option value="!!}{!! str_replace(' ','_',$model->Model) !!}{!! ">$model->Model</option>"!!}
                            @endforeach
                        </select>
                    </label>
        </div>
        <div><input type="submit" value="Posalji" id='dugme'></div>  
    </div>
</form>

@endsection