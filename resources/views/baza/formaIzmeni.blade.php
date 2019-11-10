@extends('mainPage')
@section('Page')

{{-- @php
    // var_dump($model); var_dump($cena_max);
    // var_dump($model->Model);
    // var_dump($model->opis);
@endphp --}}

<form class="formZakazivanje" method="POST" action="/baza/posalji3">
    <div class="flexColumn">
        <div class="flexRow">
                @csrf 
        </div>
        <div class="flexRow">
            <label for="Model">Model Automobila<input type="text" name="Model" id="Model" value={!! str_replace(' ','_',$model->Model) !!} ></label>
            <label for="slika">Ime fajla slike<input type="text" name="slika" id="slika" value={!! substr($model->slika,8) !!}></label>
        </div>
        <div class="flexRow">
            <label for="Klasa">
                Klasa
                <select name="Klasa" id="Klasa">
                    <option value="mala" 
                    @if ($model->Klasa==='mala')
                        {!! "selected" !!}
                    @endif
                    >mala</option>
                    <option value="srednja"
                    @if ($model->Klasa==='srednja')
                        {!! "selected" !!}
                    @endif>srednja</option>
                    <option value="velika"
                    @if ($model->Klasa==='velika')
                        {!! "selected" !!}
                    @endif>velika</option>
                    <option value="luksuzna"
                    @if ($model->Klasa==='luksuzna')
                        {!! "selected" !!}
                    @endif>luksuzna</option>
                </select>
            </label>
            <label for="Tip_menjaca">
                Tip menjaca
                <select name="Tip_menjaca" id="Tip_menjaca">
                    <option value="manuelni"
                    @if ($model->Tip_menjaca==='manuelni')
                        {!! "selected" !!}
                    @endif>manuelni</option>
                    <option value="automatski"
                    @if ($model->Tip_menjaca==='automatski')
                        {!! "selected" !!}
                    @endif>automatski</option>
                </select>
            </label>
        </div>
        <div class="flexRow">
            <label for="Broj_sedista">Broj Sedista<input type="number" name="Broj_sedista" id="Broj_sedista" value={!! $model->Broj_sedista !!}></label>
            <label for="Broj_vrata">Broj Vrata<input type="number" name="Broj_vrata" id="Broj_vrata" value={!! $model->Broj_vrata !!}></label>
            <label for="Broj_torbi">Broj Torbi<input type="number" name="Broj_torbi" id="Broj_torbi" value={!! $model->Broj_torbi !!}></label>
        </div>
        <div class="flexRow">
            <label for="opis">Opis <br><textarea name="opis" id="opis" cols="100" rows="10" >{!! $model->opis !!}</textarea></label>
        </div>
        <div class="flexRow">
                <label for="cena_3">Cena za do 3 dana<input type="number" name="cena_3" id="cena_3" value={!! $cena_3->cena_po_danu !!}></label>
                <label for="cena_7">Cena za do 7 dana<input type="number" name="cena_7" id="cena_7" value={!! $cena_7->cena_po_danu !!}></label>
                <label for="cena_max">Cena za vise od 7 dana<input type="number" name="cena_max" id="cena_max" value={!! $cena_max->cena_po_danu !!}></label>
        </div>
        <div><input type="submit" value="Izmeni" id='dugme'></div>  
    </div>
</form>

@endsection