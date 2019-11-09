@extends('mainPage')
@section('Page')

<form class="formZakazivanje" method="POST" action="/baza/posalji2">
    <div class="flexColumn">
        <div class="flexRow">
                @csrf 
        </div>
        {{-- <div class="flexRow">
            <label for="Model">Model Automobila<input type="text" name="Model" id="Model"></label>
        </div> --}}
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
</form>

@endsection