@extends('mainPage')
@section('Page')

<form method="POST" action="/rezervacijeInfo/extendReservation" class="sveRez">
    <div class="flexColumn">
        <div>@csrf</div>
        <div class="flexRow">
            <label for="rez_id">ID Rezervacije <input type="num" name="rez_id" id="rez_id" value="{{ $id }}" readonly required></label>
            <label for="brojDana">Broj dana <input type="num" name="brojDana" id="brojDana" required></label>
        </div>
        <div><input type="submit" value="Posalji" id="dugme"> </div>
    </div>
</form>

<div class="response"></div>

<script src={{ asset('/js/extendForm.js') }}></script>
<script>
    extendFormBlade.extendForm();    
</script>

@endsection